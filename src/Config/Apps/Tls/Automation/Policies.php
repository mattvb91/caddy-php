<?php

namespace mattvb91\CaddyPhp\Config\Apps\Tls\Automation;

use mattvb91\CaddyPhp\Interfaces\Apps\Tls\Automation\Policies\IssuerInterface;
use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Policies implements Arrayable
{
    /** @var array<string>|null  */
    private ?array $subjects;

    /** @var array<IssuerInterface>|null  */
    private ?array $issuers;

    public function addSubjects(string $subject): static
    {
        if (!isset($this->subjects)) {
            $this->subjects = [$subject];
        } else {
            $this->subjects[] = $subject;
        }

        return $this;
    }

    public function addIssuer(IssuerInterface $issuer): static
    {
        if (!isset($this->subjects)) {
            $this->issuers = [$issuer];
        } else {
            $this->issuers[] = $issuer;
        }

        return $this;
    }

    public function toArray(): array
    {
        $config = [];

        if (isset($this->subjects)) {
            $config['subjects'] = $this->subjects;
        }

        if (isset($this->issuers)) {
            $config['issuers'] = array_map(function (IssuerInterface $issuer) {
                return $issuer->toArray();
            }, $this->issuers);
        }

        return $config;
    }
}
