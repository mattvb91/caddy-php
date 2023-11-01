<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle;

use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\Authentication\ProviderInterface;
use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\HandlerInterface;

/**
 * https://caddyserver.com/docs/json/apps/http/servers/routes/handle/authentication/
 */
class Authentication implements HandlerInterface
{
    /** @var ProviderInterface[]  */
    private array $_providers;

    public function addProvider(ProviderInterface $provider): static
    {
        $this->_providers[] = $provider;

        return $this;
    }

    public function toArray(): array
    {
        $config = [
            'handler' => $this->getHandler(),
        ];

        if (count($this->_providers)) {
            $config['providers'] = array_map(static function (ProviderInterface $provider) {
                return [$provider->getModuleName() => $provider->toArray()];
            }, $this->_providers)[0];//TODO there has to be a better way than [0]
        }

        return $config;
    }


    public function getHandler(): string
    {
        return 'authentication';
    }
}