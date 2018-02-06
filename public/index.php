<?php

use GuzzleHttp\Psr7\ServerRequest;
use Jojotique\Framework\App;

require_once '../vendor/autoload.php';

$app = new App();

$response = $app->run(ServerRequest::fromGlobals());

\Http\Response\send($response);
