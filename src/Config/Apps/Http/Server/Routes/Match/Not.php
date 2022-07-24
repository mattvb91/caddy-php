<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Match;

use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Match\MatcherInterface;

class Not implements MatcherInterface
{
    private ?array $_not;

    public function addNotMatcher(MatcherInterface $matcher): static
    {
        if (!isset($this->_not)) {
            $this->_not = [$matcher];
        } else {
            $this->_not[] = $matcher;
        }

        return $this;
    }

    public function toArray(): array
    {
        return [
            'not' => array_map(static function (MatcherInterface $matcher) {
                return $matcher->toArray();
            }, $this->_not),
        ];
    }
}