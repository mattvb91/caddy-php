<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Authentication\Providers\HttpBasic;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Account implements Arrayable
{

    private string $_username;

    private string $_password;

    private ?string $_salt;

    public function __construct(string $username, string $password, ?string $salt = null)
    {
        $this->_username = $username;
        $this->_password = $password;
        $this->_salt = $salt;
    }

    public function toArray(): array
    {
        $config = [
            'username' => $this->_username,
            'password' => base64_encode($this->_password),
        ];

        if ($this->_salt) {
            $config['salt'] = $this->_salt;
        }

        return $config;
    }
}