<?php

namespace mattvb91\CaddyPhp\Config\Apps\Tls\Automation\Policies\Issuers;

use mattvb91\CaddyPhp\Config\Apps\Tls\Automation\Policies\Issuers\Acme\Challenges;
use mattvb91\CaddyPhp\Interfaces\Apps\Tls\Automation\Policies\IssuerInterface;

class Acme implements IssuerInterface
{
    private ?string $email;

    private ?Challenges $challenges;

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function setChallenges(Challenges $challenges): static
    {
        $this->challenges = $challenges;

        return $this;
    }

    public function toArray(): array
    {
        $config = [
            'module' => $this->getModuleName(),
        ];

        if (isset($this->email)) {
            $config['email'] = $this->email;
        }

        if (isset($this->challenges)) {
            $config['challenges'] = $this->challenges->toArray();
        }

        return $config;
    }

    public function getModuleName(): string
    {
        return 'acme';
    }
}
