<?php
require_once 'public/index.php';

$container = $app->getContainer();

$migrations = [];
$seeds = [];

// Ajoute des migrations spécifiques aux modules si nécessaire
// Ajoute des seeders spécifiques aux modules si nécessaire
foreach ($modules as $module) {
    if ($module::MIGRATIONS != null) {
        $migrations[] = ($module::MIGRATIONS);
    }

    if ($module::SEEDS != null) {
        $seeds[] = ($module::SEEDS);
    }
}

return [
    'paths'        => [
        'migrations' => $migrations,
        'seeds'      => $seeds
    ],
    'environments' => [
        'default_database' => 'development',
        'development'      => [
            'adapter' => 'mysql',
            'host'    => $container->get('database.host'),
            'name'    => $container->get('database.name'),
            'user'    => $container->get('database.username'),
            'pass'    => $container->get('database.password'),
            'port'    => 3306,
            'charset' => 'utf8'
        ]
    ]
];

