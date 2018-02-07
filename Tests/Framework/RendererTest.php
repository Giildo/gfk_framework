<?php

namespace Tests\Framework;

use Jojotique\Framework\Renderer\PHPRenderer;
use PHPUnit\Framework\TestCase;

class RendererTest extends TestCase
{
    /**
     * @var PHPRenderer
     */
    private $renderer;

    public function setUp()
    {
        $this->renderer = new PHPRenderer(__DIR__ . '/Views');
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
