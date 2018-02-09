<?php

namespace Jojotique\Framework\Actions;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * Rajoute des méthodes liées à l'utilisation du Router
 *
 * Trait RouterAwareAction
 * @package Jojotique\Framework\Actions
 */
trait RouterAwareAction
{
    /**
     * Renvoie une réponse de redirection
     *
     * @param string $path
     * @param array|null $params
     * @return ResponseInterface
     */
    public function redirect(string $path, ?array $params = []): ResponseInterface
    {
        $redirectionUri = $this->router->generateUri($path, $params);

        return (new Response())
            ->withStatus(301)
            ->withHeader('location', $redirectionUri);
    }
}
