<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\ReverseProxy\Transport;

use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\ReverseProxy\TransportInterface;

/**
 * https://caddyserver.com/docs/json/apps/http/servers/routes/handle/reverse_proxy/transport/fastcgi/
 */
class FastCGI implements TransportInterface
{
    private ?string $_root;

    /** @var string[]|null  */
    private ?array $_splitPath;

    public function setRoot(string $root): static
    {
        $this->_root = $root;

        return $this;
    }

    /**
     * @param string[] $splitPath
     * @return $this
     */
    public function setSplitPath(array $splitPath): static
    {
        $this->_splitPath = $splitPath;

        return $this;
    }

    public function toArray(): array
    {
        $array = [
            'protocol' => $this->getProtocol(),
        ];

        if (isset($this->_splitPath)) {
            $array['split_path'] = $this->_splitPath;
        }

        if (isset($this->_root)) {
            $array['root'] = $this->_root;
        }

        return $array;
    }

    public function getProtocol(): string
    {
        return 'fastcgi';
    }
}