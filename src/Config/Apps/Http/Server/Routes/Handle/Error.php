<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle;

use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\HandlerInterface;

class Error implements HandlerInterface
{
    private string $_error;

    private string|int $_statusCode;

    public function setError(string $error): static
    {
        $this->_error = $error;

        return $this;
    }

    public function setStatusCode(int|string $statusCode): static
    {
        $this->_statusCode = $statusCode;

        return $this;
    }


    public function toArray(): array
    {
        $config = [
            'handler' => $this->getHandler()
        ];

        if(isset($this->_error)) {
            $config['error'] = $this->_error;
        }

        if(isset($this->_statusCode)) {
            $config['status_code'] = $this->_statusCode;
        }

        return $config;
    }

    public function getHandler(): string
    {
        return 'error';
    }
}