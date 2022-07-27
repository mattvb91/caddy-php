<?php

namespace mattvb91\CaddyPhp\Config\Apps\Tls\Automation\Policies\Issuers;

use mattvb91\CaddyPhp\Config\Apps\Tls\Automation\Policies\Issuers\Acme\Challenges;
use mattvb91\CaddyPhp\Interfaces\Apps\Tls\Automation\Policies\IssuerInterface;

class Acme implements IssuerInterface
{
    private ?string $_email;

    private ?Challenges $_challenges;

    public function setEmail(string $email): static
    {
        $this->_email = $email;

        return $this;
    }

    public function setChallenges(Challenges $challenges): static
    {
        $this->_challenges = $challenges;

        return $this;
    }

    public function toArray(): array
    {
        $config = [
            'module' => $this->getModuleName(),
        ];

        if (isset($this->_email)) {
            $config['email'] = $this->_email;
        }

        if (isset($this->_challenges)) {
            $config['challenges'] = $this->_challenges->toArray();
        }

        return $config;
    }

    public function getModuleName(): string
    {
        return 'acme';
    }
}