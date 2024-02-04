<?php

declare(strict_types=1);

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Match;

use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Match\MatcherInterface;

class Protocol implements MatcherInterface
{
    private ?string $protocol;

    public function __construct(string $protocol)
    {
        $this->protocol = $protocol;
    }

    public function toArray(): array
    {
        return [
            'protocol' => $this->protocol,
        ];
    }
}
