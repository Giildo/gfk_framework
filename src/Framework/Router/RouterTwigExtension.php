<?php

namespace Jojotique\Framework\Router;

use Jojotique\Framework\Router;
use Twig_Extension;
use Twig_SimpleFunction;

class RouterTwigExtension extends Twig_Extension
{
    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @return array|\Twig_Function[]
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('path', [$this, 'pathFor'])
        ];
    }

    /**
     * @param string $path
     * @param array|null $params
     * @return string
     */
    public function pathFor(string $path, ?array $params = []): string
    {
        return $this->router->generateUri($path, $params);
    }
}
