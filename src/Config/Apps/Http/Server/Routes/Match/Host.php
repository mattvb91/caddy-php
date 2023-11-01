<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Match;

use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Match\MatcherInterface;

class Host implements MatcherInterface
{
    /**
     * We need unique identifiers for all our hosts
     * so we can later retrieve them to attach domains to the correct paths
     */
    private string $_identifier;

    /**
     * @var array<string>
     */
    private array $_hosts = [];

    public function __construct(string $identifier)
    {
        $this->_identifier = $identifier;
    }

    public function getIdentifier(): string
    {
        return $this->_identifier;
    }

    /**
     * @param array<string> $hosts
     * @return $this
     */
    public function setHosts(array $hosts): static
    {
        $this->_hosts = $hosts;

        return $this;
    }

    public function addHost(string $host): void
    {
        $this->_hosts = [$host, ...$this->_hosts];
    }

    /**
     * DO NOT CALL MANUALLY
     * This is used for when caddy->removeHostname() is called to keep this object in sync
     */
    public function syncRemoveHost(string $hostname): void
    {
        unset($this->_hosts[array_search($hostname, $this->_hosts)]);
    }

    /**
     * @return string[]
     */
    public function getHosts(): array
    {
        return $this->_hosts;
    }

    public function toArray(): array
    {
        return [
            'host' => $this->_hosts,
        ];
    }
}