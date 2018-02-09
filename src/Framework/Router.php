<?php

namespace Jojotique\Framework;

use Jojotique\Framework\Router\Route;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Router\FastRouteRouter;
use Zend\Expressive\Router\Route as ZendRoute;

/**
 * Class Router
 * Register and match Routes
 * @package Jojotique\Framework
 */
class Router
{
    /**
     * @var FastRouteRouter
     */
    private $router;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->router = new FastRouteRouter();
    }

    /**
     * @param string $path
     * @param callable|string $callback
     * @param string $nameRoute
     */
    public function get(string $path, $callback, string $nameRoute): void
    {
        $this->router->addRoute(new ZendRoute($path, $callback, ['GET'], $nameRoute));
    }

    /**
     * @param ServerRequestInterface $request
     * @return Route|null
     */
    public function match(ServerRequestInterface $request): ?Route
    {
        $routeResult = $this->router->match($request);

        if ($routeResult->isSuccess()) {
            return new Route(
                $routeResult->getMatchedRouteName(),
                $routeResult->getMatchedMiddleware(),
                $routeResult->getMatchedParams()
            );
        }

        return null;
    }

    /**
     * Utilise la méthode "generateUri" de FastRouteRouter
     * @param string $routeName
     * @param array|null $params
     * @param array|null $queryArgs
     * @return null|string
     */
    public function generateUri(string $routeName, ?array $params = [], ?array $queryArgs = []): ?string
    {
        $uri = $this->router->generateUri($routeName, $params, $queryArgs);

        if (!empty($queryArgs)) {
            $uri .= '?' . http_build_query($queryArgs);
        }

        return $uri;
    }
}
