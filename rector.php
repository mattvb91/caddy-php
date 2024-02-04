<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {

    $rectorConfig->paths([
        __DIR__ . '/src',
    ]);

    // register a single rule
    $rectorConfig->rule(InlineConstructorDefaultToPropertyRector::class);

    // define sets of rules
        $rectorConfig->sets([
            \Rector\Set\ValueObject\SetList::DEAD_CODE,
            \Rector\Set\ValueObject\SetList::CODE_QUALITY,
            \Rector\Set\ValueObject\SetList::TYPE_DECLARATION,
        ]);
};
