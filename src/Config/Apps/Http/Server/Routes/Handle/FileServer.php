<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle;

use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\HandlerInterface;

class FileServer implements HandlerInterface
{
    private $_root = "";

    public function setRoot(string $root): static
    {
        $this->_root = $root;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'handler' => $this->getHandler(),
            'root'    => $this->_root,
        ];
    }

    public function getHandler(): string
    {
        return 'file_server';
    }
}