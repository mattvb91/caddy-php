<?php

namespace mattvb91\CaddyPhp;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use mattvb91\CaddyPhp\Config\Admin;
use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Match\Host;
use mattvb91\CaddyPhp\Config\Logging;
use mattvb91\CaddyPhp\Exceptions\CaddyClientException;
use mattvb91\CaddyPhp\Interfaces\App;
use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Caddy implements Arrayable
{
    /**
     * This is the collection of hosts with the associated paths to where they are
     * in the config.
     *
     * We then use that to post against that individual host when adding a new domain.
     *
     * example: /config/apps/http/servers/srv0/routes/0/match/0/host/0
     *
     * We need to build that path once based on the config and then cache it here. The format is
     * [ host_identifier => ['path' => '/anything', 'host' => &$host]
     * @var array<string, array{
     *         path: string,
     *         host: Host
     *      }>
     */
    private array $hostsCache = [];

    private Client $client;

    private Admin $admin;

    private ?Logging $logging;

    /** @var App[] */
    private array $apps = [];

    private string $hostname;

    private string $cacheHostnameHeader;

    public function __construct(
        string $hostname = 'caddy',
        Admin $admin = new Admin(),
        Client $client = null,
        string $cacheHostnameHeader = 'localhost'
    ) {
        $this->setAdmin($admin);
        $this->hostname = $hostname;
        $this->cacheHostnameHeader = $cacheHostnameHeader;

        $this->client = $client ?? new Client([
            'base_uri' => $hostname . $this->getAdmin()->getListen() . '/config',
            'headers'  => [
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * If you are managing your hosts from an external source (for example db) and not directly in
     * your config you should sync your hosts from the caddy config before
     * making any changes for example trying to remove hosts
     */
    public function syncHosts(string $hostIdentifier): void
    {
        $this->buildHostsCache($hostIdentifier);

        /** @var string[] $hosts */
        $hosts = json_decode($this->client->get($this->hostsCache[$hostIdentifier]['path'])->getBody(), true);

        $this->hostsCache[$hostIdentifier]['host']->setHosts($hosts);
    }

    /**
     * @throws \Exception
     */
    public function addHostname(string $hostIdentifier, string $hostname): bool
    {
        $this->buildHostsCache($hostIdentifier);

        if (
            $this->client->put($this->hostsCache[$hostIdentifier]['path'] . '/0', [
                'json' => $hostname,
            ])->getStatusCode() === 200
        ) {
            $this->hostsCache[$hostIdentifier]['host']->addHost($hostname);
            return true;
        }

        return false;
    }

    /**
     * @throws \Exception
     */
    public function removeHostname(string $hostIdentifier, string $hostname): bool
    {
        $this->buildHostsCache($hostIdentifier);

        $path = $this->hostsCache[$hostIdentifier]['path'];
        $path = $path . '/' . array_search($hostname, $this->hostsCache[$hostIdentifier]['host']->getHosts());

        if (
            $this->client->delete($path, [
                'json' => $hostname,
            ])->getStatusCode() === 200
        ) {
            $this->hostsCache[$hostIdentifier]['host']->syncRemoveHost($hostname);
            return true;
        }

        return false;
    }

    /**
     * Get the current config of the caddy server.
     *
     * TODO we should be able to build our $caddy object back up from this.
     * So instead of toArray we should be able to do fromArray() or something
     *
     * @throws \JsonException|\GuzzleHttp\Exception\GuzzleException
     */
    public function getRemoteConfig(): object
    {
        /** @var object */
        return json_decode($this->client->get('/config')->getBody(), false, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * This is responsible for flushing the individual caches of items on the caddy server.
     *
     * @param string[] $surrogates
     * @throws GuzzleException
     */
    public function flushSurrogates(array $surrogates): bool
    {
        //TODO this is missing the fact that you could customize your cache paths.

        return $this->client->request('PURGE', 'http://' . $this->hostname . '/cache/souin', [
            'headers' => [
                'Surrogate-Key' => implode(', ', $surrogates),
                'Host'          => $this->cacheHostnameHeader,
            ],
        ])->getStatusCode() === 204;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function load(): bool
    {
        try {
            return $this->client->post('/load', [
                'json' => $this->toArray(),
            ])->getStatusCode() === 200;
        } catch (ClientException $e) {
            throw new CaddyClientException(
                $e->getResponse()->getBody() . PHP_EOL . json_encode($this->toArray(), JSON_PRETTY_PRINT)
            );
        }
    }

    /**
     * If you need to query something directly you can use the Guzzle client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    public function getAdmin(): Admin
    {
        return $this->admin;
    }

    protected function setAdmin(Admin $admin): static
    {
        $this->admin = $admin;

        return $this;
    }

    public function setLogging(Logging $logging): static
    {
        $this->logging = $logging;

        return $this;
    }

    public function addApp(App $app): static
    {
        /** @var string $name */
        $name = strrchr(get_class($app), '\\');
        $namespace = strtolower(substr($name, 1));

        $this->apps[$namespace] = $app;

        return $this;
    }

    public function toArray(): array
    {
        $config = [];

        if (isset($this->admin)) {
            $config['admin'] = $this->admin->toArray();
        }

        if (isset($this->logging)) {
            $config['logging'] = $this->logging->toArray();
        }

        if ($this->apps !== []) {
            $apps = [];

            array_map(static function (App $app, string $appNamespace) use (&$apps): void {
                $apps[$appNamespace] = $app->toArray();
            }, $this->apps, array_keys($this->apps));

            $config['apps'] = $apps;
        }

        return $config;
    }

    /**
     * @throws \Exception
     */
    protected function buildHostsCache(string $hostIdentifier): void
    {
        if (!array_key_exists($hostIdentifier, $this->hostsCache)) {
            //Find the host so we can get its path

            $hostPath = null;
            foreach ($this->apps as $app) {
                if ($found = findHost($app, $hostIdentifier)) {
                    $hostPath = $found;
                    break;
                }
            }

            if (!$hostPath) {
                throw new \Exception('Host does not exist. Check your host identified');
            }

            $this->hostsCache[$hostIdentifier] = $hostPath;
        }
    }
}
