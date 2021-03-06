<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Match;

use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Match\MatcherInterface;

class Path implements MatcherInterface
{
    private array $_paths = [];

    public function setPaths(array $paths): static
    {
        $this->_paths = $paths;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'path' => $this->_paths,
        ];
    }
}