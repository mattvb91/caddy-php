<?php

namespace mattvb91\CaddyPhp;

use mattvb91\CaddyPhp\Config\Apps\Http;
use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Match\Host;
use mattvb91\CaddyPhp\Traits\IterableProps;


/**
 * @param string|array<string, array<Http>|object|string>|object $objectToWalk
 * @param string $hostToFind
 * @param string $path
 * @return array{
 *     path: string,
 *     host: Host
 * }|null
 */
function findHost(string|array|object $objectToWalk, string $hostToFind, string $path = ''): ?array
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
        if (method_exists($objectToWalk, 'iterateAllProperties')) {
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

    return null;
}