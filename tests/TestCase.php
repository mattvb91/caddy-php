<?php

namespace Tests;

use GuzzleHttp\Client;
use mattvb91\CaddyPhp\Caddy;
use mattvb91\CaddyPhp\Config\Apps\Http\Server;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * We need to wait for caddy to reload its config before we continue
     * with new tests as we may be testing against an unrefreshed config.
     *
     * Confirm do we actually need to wait or is it instant?
     */
    public function assertCaddyConfigLoaded(Caddy $caddy): void
    {
        $caddy->load();

        $maxRetries = 3;
        $loaded = false;

        do {
            $maxRetries--;
            $client = new Client([
                'base_uri' => 'caddy:2019',
            ]);

            $request = $client->get('/config');
            $remoteConfig = json_decode($request->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
            $instanceConfig = $caddy->toArray();

            /** @var  $instanceConfig */
            if ($instanceConfig == $remoteConfig) {
                $this->assertEquals($instanceConfig, $remoteConfig);
                return;
            }

            sleep(1); //Wait for caddy to refresh
        } while ($maxRetries > 0 && !$loaded);

        if (!$loaded) {
            $this->fail('Couldnt verify the config has been loaded');
        }
    }

    public function getServerForTest(): Server
    {
        return (new Server())
            ->setListen([':80'])
            ->setReadTimeout(1)
            ->setReadHeaderTimeout(2)
            ->setWriteTimeout(3)
            ->setIdleTimeout(4)
            ->setMaxHeaderBytes(5)
            ->setStrictSniHost(true)
            ->setExperimentalHttp3(true)
            ->setAllowH2c(true);
    }
}