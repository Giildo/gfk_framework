<?php

namespace Tests\Framework\Module;

use Jojotique\Framework\Router;
use stdClass;

/**
 * Class TestModule
 * Pour tester l'erreur de l'App en cas de retour quand c'est ni un string, ni une ResponseInterface
 * @package Tests\Framework\Module
 */
class TestModule
{
    /**
     * TestModule constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $router->get('/essai', function () {
            return new stdClass();
        }, 'essai');
    }
}
