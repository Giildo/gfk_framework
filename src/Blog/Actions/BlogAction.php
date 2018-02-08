<?php

namespace Jojotique\Blog\Actions;

use GuzzleHttp\Psr7\Response;
use Jojotique\Framework\Renderer\RendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogAction
{
    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * BlogAction constructor.
     * @param RendererInterface $renderer
     */
    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $slug = $request->getAttribute('slug');

        if ($slug) {
            return $this->show($slug);
        } else {
            return $this->index();
        }
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
     * @param string $slug
     * @return ResponseInterface
     */
    public function show(string $slug): ResponseInterface
    {
        return new Response(200, [], $this->renderer->render('@blog/show', [
            'slug' => $slug
        ]));
    }
}
