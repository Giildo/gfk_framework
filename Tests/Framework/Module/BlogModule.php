<?php

namespace Tests\Framework\Module;

use GuzzleHttp\Psr7\Response;
use Jojotique\Framework\Renderer\RendererInterface;
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
     * @var RendererInterface
     */
    private $renderer;

    /**
     * BlogModule constructor.
     * Initialise les différentes Routes
     * @param Router $router
     * @param RendererInterface $renderer
     */
    public function __construct(Router $router, RendererInterface $renderer)
    {
        $this->renderer = $renderer;
        $this->renderer->addPath(dirname(__DIR__) . '/Views', 'blog');

        $router->get('/blog', [$this, 'index'], 'blog.index');
        $router->get('/blog/{slug}', [$this, 'show'], 'blog.show');
    }

    /**
     * Liste les articles
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        return new Response(200, [], $this->renderer->render('@blog/index'));
    }

    /**
     * Affiche un Post unique
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function show(ServerRequestInterface $request): ResponseInterface
    {
        return new Response(200, [], $this->renderer->render('@blog/show', [
            'slug' => $request->getAttribute('slug')
        ]));
    }
}
