<?php

return [
    'routes' => [
        ['name' => 'config#setAdminConfig', 'url' => '/admin-config', 'verb' => 'PUT'],
        ['name' => 'config#setPersonalConfig', 'url' => '/personal-config', 'verb' => 'PUT'],
        ['name' => 'config#index', 'url' => '/', 'verb' => 'GET'],
    ],
];
