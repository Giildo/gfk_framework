<?php

namespace Tests\Framework;


use Exception;
use GuzzleHttp\Psr7\ServerRequest;
use Jojotique\Framework\App;
use Jojotique\Framework\Renderer\PHPRenderer;
use PHPUnit\Framework\TestCase;
use Tests\Framework\Module\BlogModule;
use Tests\Framework\Module\TestModule;

/**
 * Tests Unitaires
 * Class AppTest
 * @package Tests\Framework
 */
class AppTest extends TestCase
{
    private $renderer;

    public function setUp()
    {
        $this->renderer = new PHPRenderer();
        $this->renderer->addPath(__DIR__ . '/Views');
    }

    /**
     * Test si la redirection en cas de "/" final fonctionne
     * @throws Exception
     */
    public function testRedirectTrailingSlash()
    {
        $app = new App([], [
            'renderer' => $this->renderer
        ]);
        $request = new ServerRequest('GET', '/demoSlash/');
        $response = $app->run($request);

        $this->assertContains('/demoSlash', $response->getHeader('Location'));
        $this->assertEquals(301, $response->getStatusCode());
    }

    /**
     * Test si les URL autorisées fonctionnent
     * @throws Exception
     */
    public function testBlog()
    {
        $app = new App([
            BlogModule::class
        ], [
            'renderer' => $this->renderer
        ]);

        $request = new ServerRequest('GET', '/blog');
        $response = $app->run($request);

        $this->assertEquals('<h1>Bienvenue sur le blog</h1>', (string)$response->getBody());
        $this->assertEquals(200, $response->getStatusCode());

        $requestSingle = new ServerRequest('GET', '/blog/post-essai');
        $responseSingle = $app->run($requestSingle);

        $this->assertEquals('<h1>Bienvenue sur l\'article post-essai</h1>', (string)$responseSingle->getBody());
        $this->assertEquals(200, $responseSingle->getStatusCode());
    }

    /**
     * @throws Exception
     */
    public function testFakeModule()
    {
        $app = new App([
            TestModule::class
        ], [
            'renderer' => $this->renderer
        ]);

        $request = new ServerRequest('GET', '/essai');

        $this->expectException(Exception::class);
        $app->run($request);
    }

    /**
     * Test si les URL non autorisées sont bien renvoyées vers une page 404
     * @throws Exception
     */
    public function testUnknowUrl()
    {
        $app = new App([], [
            'renderer' => $this->renderer
        ]);
        $request = new ServerRequest('GET', '/essai');
        $response = $app->run($request);

        $this->assertEquals('<h1>Erreur 404</h1>', (string)$response->getBody());
        $this->assertEquals(404, $response->getStatusCode());
    }
}