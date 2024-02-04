<?php

declare(strict_types=1);

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Authentication\Providers\HttpBasic;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Account implements Arrayable
{
    private string $username;

    private string $password;

    private ?string $salt;

    public function __construct(string $username, string $password, ?string $salt = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->salt = $salt;
    }

    public function toArray(): array
    {
        $config = [
            'username' => $this->username,
            'password' => base64_encode(password_hash($this->password, PASSWORD_BCRYPT)),
        ];

        if ($this->salt) {
            $config['salt'] = $this->salt;
        }

        return $config;
    }
}
