<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\ReverseProxy\Transport;

use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\ReverseProxy\TransportInterface;

/**
 * https://caddyserver.com/docs/json/apps/http/servers/routes/handle/reverse_proxy/transport/fastcgi/
 */
class FastCGI implements TransportInterface
{
    private ?string $root;

    /** @var string[]|null  */
    private ?array $splitPath;

    public function setRoot(string $root): static
    {
        $this->root = $root;

        return $this;
    }

    /**
     * @param string[] $splitPath
     * @return $this
     */
    public function setSplitPath(array $splitPath): static
    {
        $this->splitPath = $splitPath;

        return $this;
    }

    public function toArray(): array
    {
        $array = [
            'protocol' => $this->getProtocol(),
        ];

        if (isset($this->splitPath)) {
            $array['split_path'] = $this->splitPath;
        }

        if (isset($this->root)) {
            $array['root'] = $this->root;
        }

        return $array;
    }

    public function getProtocol(): string
    {
        return 'fastcgi';
    }
}
