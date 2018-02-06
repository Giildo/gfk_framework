<?php

namespace Jojotique\Framework;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Classe qui représente notre application
 * Class App
 * @package Jojotique\Framework
 */
class App
{
    /**
     * Lance l'application en récupérant une requête et en revoyant une réponse
     * @param ServerRequestInterface $request Classe qui implémente une Interface PSR7 friendly
     * @return ResponseInterface Classe qui implémente une Interface PSR7 friendly
     */
    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri()->getPath();

        if (!empty($uri) && $uri[-1] === "/") {
            return (new Response())
                ->withStatus(301, 'Move Permanently')
                ->withHeader('Location', substr($uri, 0, -1));
        }

        if (!empty($uri)) {
            switch ($uri) {
                case '/blog':
                    return new Response(200, [], '<h1>Bienvenue sur le blog</h1>');
                    break;
            }
        }

        return new Response(404, [], '<h1>Erreur 404</h1>');
    }
}
