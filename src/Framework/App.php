<?php

namespace Jojotique\Framework;

use Exception;
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
     * List of modules
     * @var array Sauvegarde le module qui est passé lors de la construction de App
     */
    private $module = [];

    /**
     * @var Router
     */
    private $router;

    /**
     * App constructor.
     * @param string[] $modules Liste des modules à charger
     * @param array|null $dependencies
     */
    public function __construct(?array $modules = [], ?array $dependencies = [])
    {
        $this->router = new Router();

        if (array_key_exists('renderer', $dependencies)) {
            $dependencies['renderer']->addGlobal('router', $this->router);
        }

        foreach ($modules as $module) {
            $this->module[] = new $module($this->router, $dependencies['renderer']);
        }
    }

    /**
     * Lance l'application en récupérant une requête et en revoyant une réponse
     * @param ServerRequestInterface $request Classe qui implémente une Interface PSR7 friendly
     * @return ResponseInterface Classe qui implémente une Interface PSR7 friendly
     * @throws Exception
     */
    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri()->getPath();

        if (!empty($uri) && $uri[-1] === "/") {
            return (new Response())
                ->withStatus(301, 'Move Permanently')
                ->withHeader('Location', substr($uri, 0, -1));
        }

        $route = $this->router->match($request);

        if (is_null($route)) {
            return new Response(404, [], '<h1>Erreur 404</h1>');
        }

        // Passe les paramètres à la $request
        $params = $route->getParams();
        $request = array_reduce(array_keys($params), function ($request, $key) use ($params) {
            return $request->withAttribute($key, $params[$key]);
        }, $request);

        $response = call_user_func_array($route->getCallback(), [$request]);

        if (is_string($response)) {
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new Exception('$response isn\'t a string or isn\'t an instance of ResponseInterface');
        }
    }
}
