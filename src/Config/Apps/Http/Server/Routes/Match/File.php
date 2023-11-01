<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Match;

use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Match\MatcherInterface;

class File implements MatcherInterface
{
    /** @var string[] */
    private array $tryFiles;

    /**
     * @param string[] $paths
     * @return $this
     */
    public function setTryFiles(array $paths): static
    {
        $this->tryFiles = $paths;

        return $this;
    }

    public function toArray(): array
    {
        $config = [];

        if (isset($this->tryFiles)) {
            $config['try_files'] = $this->tryFiles;
        }

        return [
            'file' => $config,
        ];
    }
}
