<?php

namespace mattvb91\CaddyPhp;

use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Match\Host;
use mattvb91\CaddyPhp\Traits\IterableProps;

/**
 * Walk the config objects to find the host we need
 *
 * TODO this is pretty inefficient there must be a better way to gather this.
 */
function findHost($objectToWalk, $hostToFind, $path = '')
{
    if ($objectToWalk instanceof Host) {
        if ($objectToWalk->getIdentifier() === $hostToFind && str_contains($path, 'routes') && str_contains($path, 'match')) {
            return [
                'path' => '/config/apps/http' . str_replace('_', '', $path) . '/host',
                'host' => &$objectToWalk,
            ];
        }
    }

    if (is_object($objectToWalk)) {
        $canIterate = array_key_exists(IterableProps::class, class_uses($objectToWalk));

        if ($canIterate) {
            $props = $objectToWalk->iterateAllProperties();
            if ($found = findHost($props, $hostToFind, $path)) {
                return $found;
            }

        }
    }

    if (is_array($objectToWalk)) {
        foreach ($objectToWalk as $key => $item) {
            if ($found = findHost($item, $hostToFind, $path . '/' . $key)) {
                return $found;
            }
        }
    }
}