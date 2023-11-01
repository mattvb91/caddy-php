<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle;

use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\HandlerInterface;

class FileServer implements HandlerInterface
{
    private string $root = "";

    public function setRoot(string $root): static
    {
        $this->root = $root;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'handler' => $this->getHandler(),
            'root'    => $this->root,
        ];
    }

    public function getHandler(): string
    {
        return 'file_server';
    }
}
