<?php

namespace Jojotique\Blog;

use GuzzleHttp\Psr7\Response;
use Jojotique\Framework\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class BlogModule
 * @package Jojotique\Blog
 */
class BlogModule
{
    /**
     * BlogModule constructor.
     * Initialise les différentes Routes
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $router->get('/blog', [$this, 'index'], 'blog.index');
        $router->get('/blog/{slug}', [$this, 'show'], 'blog.show');
    }

    /**
     * Liste les articles
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request): ResponseInterface
    {
        return new Response(200, [], '<h1>Bienvenue sur le blog</h1>');
    }

    /**
     * Affiche un Post unique
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function show(ServerRequestInterface $request): ResponseInterface
    {
        $slug = $request->getAttribute('slug');

        return new Response(200, [], "<h1>Bienvenue sur l'article {$slug}</h1>");
    }
}
