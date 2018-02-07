<?php

use GuzzleHttp\Psr7\ServerRequest;
use Jojotique\Blog\BlogModule;
use Jojotique\Framework\App;
use Jojotique\Framework\Renderer\TwigRenderer;

require_once '../vendor/autoload.php';

$renderer = new TwigRenderer(dirname(__DIR__) . '/Views');

$app = new App([
    BlogModule::class
], [
    'renderer' => $renderer
]);

try {
    $response = $app->run(ServerRequest::fromGlobals());
} catch (Exception $e) {
    echo $e->getMessage();
}

\Http\Response\send($response);
