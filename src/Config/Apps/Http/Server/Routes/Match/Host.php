<?php

declare(strict_types=1);

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Match;

use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Match\MatcherInterface;

class Host implements MatcherInterface
{
    /**
     * We need unique identifiers for all our hosts
     * so we can later retrieve them to attach domains to the correct paths
     */
    private string $identifier;

    /**
     * @var array<string>
     */
    private array $hosts = [];

    public function __construct(string $identifier)
    {
        $this->identifier = $identifier;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @param array<string> $hosts
     * @return $this
     */
    public function setHosts(array $hosts): static
    {
        $this->hosts = $hosts;

        return $this;
    }

    public function addHost(string $host): void
    {
        $this->hosts = [$host, ...$this->hosts];
    }

    /**
     * DO NOT CALL MANUALLY
     * This is used for when caddy->removeHostname() is called to keep this object in sync
     */
    public function syncRemoveHost(string $hostname): void
    {
        unset($this->hosts[array_search($hostname, $this->hosts)]);
    }

    /**
     * @return string[]
     */
    public function getHosts(): array
    {
        return $this->hosts;
    }

    public function toArray(): array
    {
        return [
            'host' => $this->hosts,
        ];
    }
}
