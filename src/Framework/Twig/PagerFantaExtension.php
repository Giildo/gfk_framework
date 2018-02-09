<?php

namespace Jojotique\Framework\Twig;

use Jojotique\Framework\Router;
use Pagerfanta\Pagerfanta;
use Pagerfanta\View\TwitterBootstrap4View;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Class TwigFantaExtension
 * @package Jojotique\Framework\Twig
 */
class PagerFantaExtension extends Twig_Extension
{
    /**
     * @var Router
     */
    private $router;

    /**
     * TwigFantaExtension constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('paginate', [$this, "paginate"], ['is_safe' => ['html']])
        ];
    }

    /**
     * @param Pagerfanta $paginatedResults
     * @param string $route
     * @param array|null $queryArgs
     * @return string
     */
    public function paginate(Pagerfanta $paginatedResults, string $route, ?array $queryArgs = []): string
    {
        $view = new TwitterBootstrap4View();
        return $view->render($paginatedResults, function (int $page) use ($route, $queryArgs) {
            if ($page > 1) {
                $queryArgs['p'] = $page;
            }

            return $this->router->generateUri($route, [], $queryArgs);
        });
    }
}
