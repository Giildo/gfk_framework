<?php

use DI\ContainerBuilder;
use GuzzleHttp\Psr7\ServerRequest;
use Jojotique\Blog\BlogModule;
use Jojotique\Framework\App;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

require_once '../vendor/autoload.php';

$modules = [
    BlogModule::class
];

$builder = new ContainerBuilder();
$builder->addDefinitions(dirname(__DIR__) . '/config/config.php');

// Ajoute des définitions spécifiques aux modules si nécessaire
foreach ($modules as $module) {
    if ($module::DEFINITION != null) {
        $builder->addDefinitions($module::DEFINITION);
    }
}

$container = $builder->build();

try {
    $app = new App($container, $modules);
} catch (NotFoundExceptionInterface | ContainerExceptionInterface $e) {
    echo $e->getMessage();
}

try {
    $response = $app->run(ServerRequest::fromGlobals());
} catch (Exception | NotFoundExceptionInterface | ContainerExceptionInterface $e) {
    echo $e->getMessage();
}

\Http\Response\send($response);
