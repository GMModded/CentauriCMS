<?php

return [
    "PATHS" => [
        "centauri_storage" => realpath(__DIR__ . "/../storage/Centauri") . "/",
        "centauri_storage_extensions" => realpath(__DIR__ . "/../storage/Centauri/Extensions") . "/"
    ],

    "KERNEL_LEVEL_CACHING" => [
        "status" => true,
        "callback" => \Centauri\CMS\Caches\KernelLevelCache::class,

        "filteredSlugs" => [
            "/centauri",
            "/storage",
            "/action",
            "/csrf-token"
        ]
    ]
];
