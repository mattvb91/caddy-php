<?php

declare(strict_types=1);

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle;

use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\HandlerInterface;

class Error implements HandlerInterface
{
    private string $error;

    private string|int $statusCode;

    public function setError(string $error): static
    {
        $this->error = $error;

        return $this;
    }

    public function setStatusCode(int|string $statusCode): static
    {
        $this->statusCode = $statusCode;

        return $this;
    }


    public function toArray(): array
    {
        $config = [
            'handler' => $this->getHandler()
        ];

        if (isset($this->error)) {
            $config['error'] = $this->error;
        }

        if (isset($this->statusCode)) {
            $config['status_code'] = $this->statusCode;
        }

        return $config;
    }

    public function getHandler(): string
    {
        return 'error';
    }
}
