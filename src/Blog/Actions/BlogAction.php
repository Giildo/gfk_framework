<?php

namespace Jojotique\Blog\Actions;

use GuzzleHttp\Psr7\Response;
use Jojotique\Blog\Table\PostTable;
use Jojotique\Framework\Actions\RouterAwareAction;
use Jojotique\Framework\Renderer\RendererInterface;
use Jojotique\Framework\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogAction
{
    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var PostTable
     */
    private $postTable;

    use RouterAwareAction;

    /**
     * BlogAction constructor.
     * @param RendererInterface $renderer
     * @param Router $router
     * @param PostTable $postTable
     */
    public function __construct(RendererInterface $renderer, Router $router, PostTable $postTable)
    {
        $this->renderer = $renderer;
        $this->router = $router;
        $this->postTable = $postTable;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request)
    {
        if ($request->getAttribute('id')) {
            return $this->show($request);
        } else {
            return $this->index();
        }
    }

    /**
     * Liste les articles
     *
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $posts = $this->postTable->findAll(5);

        return new Response(200, [], $this->renderer->render('@blog/index', compact('posts')));
    }

    /**
     * Affiche un Post unique
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function show(ServerRequestInterface $request): ResponseInterface
    {
        $post = $this->postTable->find($request->getAttribute('id'));

        if ($post->slug !== $request->getAttribute('slug')) {
            return $this->redirect('blog.show', [
                'slug' => $post->slug,
                'id'   => $post->id
            ]);
        }

        return new Response(200, [], $this->renderer->render('@blog/show', ['post' => $post]));
    }
}
