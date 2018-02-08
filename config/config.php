<?php

use Jojotique\Framework\Renderer\RendererInterface;
use Jojotique\Framework\Renderer\TwigRendererFactory;
use Jojotique\Framework\Router;
use Jojotique\Framework\Router\RouterTwigExtension;

use function \DI\object;
use function \DI\factory;
use function \DI\get;

return [
    'views.path' => dirname(__DIR__) . '/Views',

    'twig.extensions' => [
        get(RouterTwigExtension::class)
    ],

    RendererInterface::class => factory(TwigRendererFactory::class),
    Router::class => object(),
    RouterTwigExtension::class => object()
];
