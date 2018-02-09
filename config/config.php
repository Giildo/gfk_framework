<?php

use Jojotique\Framework\Renderer\RendererInterface;
use Jojotique\Framework\Renderer\TwigRendererFactory;
use Jojotique\Framework\Router;
use Jojotique\Framework\Router\RouterTwigExtension;
use Psr\Container\ContainerInterface;

use function \DI\object;
use function \DI\factory;
use function \DI\get;

return [
    'database.host'     => 'localhost',
    'database.username' => 'root',
    'database.password' => 'jOn79613226',
    'database.name'     => 'blog',

    'views.path' => dirname(__DIR__) . '/Views',

    'twig.extensions' => [
        get(RouterTwigExtension::class)
    ],

    RendererInterface::class   => factory(TwigRendererFactory::class),
    Router::class              => object(),
    RouterTwigExtension::class => object(),
    \PDO::class                 => function (ContainerInterface $c) {
        return $pdo = new PDO(
            'mysql:host=' . $c->get('database.host') . ';dbname=' . $c->get('database.name') . ';charset=utf8',
            $c->get('database.username'),
            $c->get('database.password'),
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }
];
