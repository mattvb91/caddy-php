<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Match;

use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Match\MatcherInterface;

class Not implements MatcherInterface
{
    /** @var array<MatcherInterface>  */
    private array $not = [];

    public function addNotMatcher(MatcherInterface $matcher): static
    {
        $this->not[] = $matcher;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'not' => array_map(static function (MatcherInterface $matcher): array {
                return $matcher->toArray();
            }, $this->not),
        ];
    }
}
