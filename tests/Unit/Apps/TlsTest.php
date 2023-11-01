<?php

namespace Tests\Unit\Apps;

use mattvb91\CaddyPhp\Config\Apps\Tls;
use Tests\TestCase;

class TlsTest extends TestCase
{

    /**
     * @coversNothing
     */
    public function test_tls_app()
    {
        $tls = (new Tls())
            ->setAutomation((new Tls\Automation())
                ->setOnDemand((new Tls\Automation\OnDemand())
                    ->setAsk('/api/platform/domainCheck')
                    ->setRateLimit((new Tls\Automation\OnDemand\RateLimit())
                        ->setBurst('5')
                        ->setInterval('2m')
                    )
                )->addPolicies((new Tls\Automation\Policies())
                    ->addSubjects('*.localhost')
                    ->addIssuer((new Tls\Automation\Policies\Issuers\Acme())
                        ->setEmail('test@test.com')
                        ->setChallenges((new Tls\Automation\Policies\Issuers\Acme\Challenges())
                            ->setDns((new Tls\Automation\Policies\Issuers\Acme\Challenges\Dns())
                                ->setProvider((new Tls\Automation\Policies\Issuers\Acme\Challenges\Dns\Provider\Route53())
                                )
                            )
                        )
                    )
                )->addPolicies((new Tls\Automation\Policies())
                    ->addSubjects('test.local')
                    ->addIssuer(new Tls\Automation\Policies\Issuers\Internal())
                )
            );

        $this->assertEquals([
            'automation' => [
                'on_demand' => [
                    'ask'        => '/api/platform/domainCheck',
                    'rate_limit' => [
                        'interval' => '2m',
                        'burst'    => 5,
                    ],
                ],
                'policies'  => [
                    [
                        'subjects' => [
                            '*.localhost',
                        ],
                        'issuers'  => [
                            [
                                "module"     => "acme",
                                "email"      => "test@test.com",
                                "challenges" => [
                                    "dns" => [
                                        "provider" => [
                                            "name" => "route53",
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    [
                        'subjects' => [
                            'test.local',
                        ],
                        'issuers'  => [
                            [
                                'module' => 'internal',
                            ],
                        ],
                    ],
                ],
            ],
        ], $tls->toArray());
    }

}