<?php

namespace Jojotique\Blog;

use Jojotique\Blog\Actions\BlogAction;
use Jojotique\Framework\Module;
use Jojotique\Framework\Renderer\RendererInterface;
use Jojotique\Framework\Router;

/**
 * Class BlogModule
 * @package Jojotique\Blog
 */
class BlogModule extends Module
{
    /**
     * Permet de définir si une config est crée, si oui sera chargée à l'index
     */
    public const DEFINITION = __DIR__ . '/config.php';

    /**
     * Permet de définir si une migration est configurée, si oui sera chargée dans Phinx
     */
    public const MIGRATIONS = __DIR__ . '/db/migrations';

    /**
     * Permet de définir si un envoie de données est configuré, si oui sera chargée dans Phinx
     */
    public const SEEDS = __DIR__ . '/db/seeds';

    /**
     * BlogModule constructor.
     * Initialise les différentes Routes
     * @param string $prefix
     * @param Router $router
     * @param RendererInterface $renderer
     */
    public function __construct(string $prefix, Router $router, RendererInterface $renderer)
    {
        $renderer->addPath(__DIR__ . '/Views', 'blog');

        $router->get($prefix, BlogAction::class, 'blog.index');
        $router->get($prefix . '/{slug:[a-z0-9\-]+}-{id:[0-9]+}', BlogAction::class, 'blog.show');
    }
}
