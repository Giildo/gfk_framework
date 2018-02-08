<?php

namespace Jojotique\Framework;

use Exception;
use GuzzleHttp\Psr7\Response;
use Psr\Container\ContainerInterface;
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
     * List of modules
     * @var array Sauvegarde le module qui est passé lors de la construction de App
     */
    private $module = [];

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * App constructor.
     * @param ContainerInterface $container
     * @param string[] $modules Liste des modules à charger
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container, ?array $modules = [])
    {
        foreach ($modules as $module) {
            $this->module[] = $container->get($module);
        }

        $this->container = $container;
    }

    /**
     * Lance l'application en récupérant une requête et en revoyant une réponse
     * @param ServerRequestInterface $request Classe qui implémente une Interface PSR7 friendly
     * @return ResponseInterface Classe qui implémente une Interface PSR7 friendly
     * @throws Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri()->getPath();

        if (!empty($uri) && $uri[-1] === "/") {
            return (new Response())
                ->withStatus(301, 'Move Permanently')
                ->withHeader('Location', substr($uri, 0, -1));
        }

        $route = $this->container->get(Router::class)->match($request);

        if (is_null($route)) {
            return new Response(404, [], '<h1>Erreur 404</h1>');
        }

        // Passe les paramètres à la $request
        $params = $route->getParams();
        $request = array_reduce(array_keys($params), function ($request, $key) use ($params) {
            return $request->withAttribute($key, $params[$key]);
        }, $request);

        // Vérification du retour
        $callback = $route->getCallback();
        if (is_string($callback)) {
            $callback = $this->container->get($callback);
        }
        $response = call_user_func_array($callback, [$request]);

        if (is_string($response)) {
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new Exception('$response n\'est pas une instance de ResponseInterface et n\'est pas un string');
        }
    }
}
