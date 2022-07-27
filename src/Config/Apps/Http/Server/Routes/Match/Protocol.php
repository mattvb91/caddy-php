<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Match;

use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Match\MatcherInterface;

enum MatchProtocol: string
{
    public const HTTP = 'http';
    public const HTTPS = 'https';
    public const GRPC = 'grpc';
}

class Protocol implements MatcherInterface
{
    private ?string $_protocol;

    public function __construct(string $protocol)
    {
        $this->_protocol = $protocol;
    }

    public function toArray(): array
    {
        return [
            'protocol' => $this->_protocol,
        ];
    }
}