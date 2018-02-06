<?php

namespace Tests\Framework;

use Exception;
use GuzzleHttp\Psr7\ServerRequest;
use Jojotique\Framework\Router;
use PHPUnit\Framework\TestCase;

/**
 * Class RouterTest
 * @package Tests\Framework
 */
class RouterTest extends TestCase
{
    /**
     * @var Router
     */
    private $router;

    /**
     * Fonction appelée au départ des tests
     */
    public function setUp(): void
    {
        $this->router = new Router();
    }

    /**
     * Test si la route est bien trouvée
     * @throws Exception
     */
    public function testGetMethod()
    {
        $request = new ServerRequest('GET', '/blog');

        $this->router->get('/blog', function () {
            return 'hello';
        }, 'blog');

        $route = $this->router->match($request);

        $this->assertEquals('blog', $route->getName());
        $this->assertEquals('hello', call_user_func_array($route->getCallback(), [$request]));
    }

    /**
     * Test si la route est trouvée avec le passage de paramètres
     * @throws Exception
     */
    public function testGetMethodWithSlug()
    {
        $request = new ServerRequest('GET', '/blog/post-1');

        $this->router->get('/blog', function () {
            return 'hello1';
        }, 'blog');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function () {
            return 'hello2';
        }, 'blog.show');

        $route = $this->router->match($request);
        $route2 = $this->router->match(new ServerRequest('GET', '/blog/mon_slug-8'));

        $this->assertEquals('blog.show', $route->getName());
        $this->assertEquals(['slug' => 'post', 'id' => '1'], $route->getParams());
        $this->assertEquals('hello2', call_user_func_array($route->getCallback(), [$request]));
        // Test with invalid adress
        $this->assertEquals(null, $route2);
    }

    /**
     * Test avec une adresse fausse si la route est bien nulle
     * @throws Exception
     */
    public function testGetMethodIfURLDoesntExist()
    {
        $request = new ServerRequest('GET', '/essai');

        $this->router->get('/blog', function () {
            return 'hello';
        }, 'blog');

        $route = $this->router->match($request);

        $this->assertEquals(null, $route);
    }

    /**
     * @throws Exception
     */
    public function testGenerateUri()
    {
        $this->router->get('/blog', function () {
            return 'hello';
        }, 'post');
        $this->router->get('/blog/{slug:[a-z\-]+}-{id:\d+}', function () {
            return 'hello2';
        }, 'blog.show');

        $uri = $this->router->generateUri('blog.show', ['slug' => 'post', 'id' => '1']);

        $this->assertEquals('/blog/post-1', $uri);
    }
}
