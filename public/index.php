<?php

use DI\ContainerBuilder;
use GuzzleHttp\Psr7\ServerRequest;
use Jojotique\Blog\BlogModule;
use Jojotique\Framework\App;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

require_once dirname(__DIR__) . '/vendor/autoload.php';

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

/* Vérifie que PHP n'est pas en ligne de commande
 * Permet d'éviter que phinx ne lance ces actions car il est en ligne de commande
 */
if (php_sapi_name() !== 'cli') {
    try {
        $response = $app->run(ServerRequest::fromGlobals());
    } catch (Exception | NotFoundExceptionInterface | ContainerExceptionInterface $e) {
        echo $e->getMessage();
    }

    \Http\Response\send($response);
}
