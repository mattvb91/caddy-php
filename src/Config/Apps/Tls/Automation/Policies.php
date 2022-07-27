<?php

namespace mattvb91\CaddyPhp\Config\Apps\Tls\Automation;

use mattvb91\CaddyPhp\Interfaces\Apps\Tls\Automation\Policies\IssuerInterface;
use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Policies implements Arrayable
{
    private ?array $_subjects;

    private ?array $_issuers;

    public function addSubjects(string $subject): static
    {
        if (!isset($this->_subjects)) {
            $this->_subjects = [$subject];
        } else {
            $this->_subjects[] = $subject;
        }

        return $this;
    }

    public function addIssuer(IssuerInterface $issuer): static
    {
        if (!isset($this->_subjects)) {
            $this->_issuers = [$issuer];
        } else {
            $this->_issuers[] = $issuer;
        }

        return $this;
    }

    public function toArray(): array
    {
        $config = [];

        if (isset($this->_subjects)) {
            $config['subjects'] = $this->_subjects;
        }

        if (isset($this->_issuers)) {
            $config['issuers'] = array_map(function (IssuerInterface $issuer) {
                return $issuer->toArray();
            }, $this->_issuers);
        }

        return $config;
    }


}