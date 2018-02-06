<?php

namespace Tests\Framework;


use GuzzleHttp\Psr7\ServerRequest;
use Jojotique\Framework\App;
use PHPUnit\Framework\TestCase;

/**
 * Tests Unitaires
 * Class AppTest
 * @package Tests\Framework
 */
class AppTest extends TestCase
{
    /**
     * Test si la redirection en cas de "/" final fonctionne
     * @return null|string
     */
    public function testRedirectTrailingSlash(): ?string
    {
        $app = new App();
        $request = new ServerRequest('GET', '/demoSlash/');
        $response = $app->run($request);

        try {
            $this->assertContains('/demoSlash', $response->getHeader('Location'));
            $this->assertEquals(301, $response->getStatusCode());
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Test si les URL autorisées fonctionnent
     * @return null|string
     */
    public function testBlog(): ?string
    {
        $app = new App();
        $request = new ServerRequest('GET', '/blog');
        $response = $app->run($request);

        try {
            $this->assertEquals('<h1>Bienvenue sur le blog</h1>', (string)$response->getBody());
            $this->assertEquals(200, $response->getStatusCode());
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Test si les URL non autorisées sont bien renvoyées vers une page 404
     * @return null|string
     */
    public function testUnknowUrl(): ?string
    {
        $app = new App();
        $request = new ServerRequest('GET', '/essai');
        $response = $app->run($request);

        try {
            $this->assertEquals('<h1>Erreur 404</h1>', (string)$response->getBody());
            $this->assertEquals(404, $response->getStatusCode());
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}