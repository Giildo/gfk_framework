<?php

use GuzzleHttp\Psr7\ServerRequest;
use Jojotique\Blog\BlogModule;
use Jojotique\Framework\App;

require_once '../vendor/autoload.php';

$app = new App([
    BlogModule::class,
    \Tests\Framework\Module\TestModule::class
]);

try {
    $response = $app->run(ServerRequest::fromGlobals());
} catch (Exception $e) {
    echo $e->getMessage();
}

\Http\Response\send($response);
