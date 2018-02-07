<?php

namespace Tests\Framework;

use Jojotique\Framework\Renderer;
use PHPUnit\Framework\TestCase;

class RendererTest extends TestCase
{
    /**
     * @var Renderer
     */
    private $renderer;

    public function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        $this->renderer = new Renderer();
    }

    /**
     * @throws \Exception
     */
    public function testRenderTheRightPath()
    {
        $this->renderer->addPath(__DIR__ . '/Views', 'blog');
        $content = $this->renderer->render('@blog/demo');
        $this->assertEquals('Salut les gens', $content);
    }

    /**
     * @throws \Exception
     */
    public function testRendererTheDefaultPath()
    {
        $this->renderer->addPath(__DIR__ . '/Views');
        $content = $this->renderer->render('demo');
        $this->assertEquals('Salut les gens', $content);
    }

    /**
     * @throws \Exception
     */
    public function testRendererWithParams()
    {
        $this->renderer->addPath(__DIR__ . '/Views', 'blog');
        $content = $this->renderer->render('@blog/blog', [
            'nom' => 'Marc'
        ]);
        $this->assertEquals('Salut Marc', $content);
    }

    /**
     * @throws \Exception
     */
    public function testGlobalParams()
    {
        $this->renderer->addPath(__DIR__ . '/Views', 'blog');
        $this->renderer->addGlobal('nom', 'Marc');
        $content = $this->renderer->render('@blog/blog');
        $this->assertEquals('Salut Marc', $content);
    }
}
