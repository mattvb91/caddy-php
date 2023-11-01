<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Match;

use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Match\MatcherInterface;

class File implements MatcherInterface
{
    /** @var string[] */
    private array $_tryFiles;

    /**
     * @param string[] $paths
     * @return $this
     */
    public function setTryFiles(array $paths): static
    {
        $this->_tryFiles = $paths;

        return $this;
    }

    public function toArray(): array
    {
        $config = [];

        if (isset($this->_tryFiles)) {
            $config['try_files'] = $this->_tryFiles;
        }

        return [
            'file' => $config,
        ];
    }
}