<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Match;

use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Match\MatcherInterface;

class Path implements MatcherInterface
{
    /** @var array<string> */
    private array $paths = [];

    /**
     * @param array<string> $paths
     * @return $this
     */
    public function setPaths(array $paths): static
    {
        $this->paths = $paths;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'path' => $this->paths,
        ];
    }
}
