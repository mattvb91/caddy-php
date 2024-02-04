<?php

declare(strict_types=1);

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Match;

enum MatchProtocol: string
{
    public const HTTP = 'http';
    public const HTTPS = 'https';
    public const GRPC = 'grpc';
}
