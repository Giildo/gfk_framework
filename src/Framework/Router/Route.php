<?php

namespace Jojotique\Framework\Router;

/**
 * Represent a matched route
 * Class Route
 * @package Jojotique\Framework\Router
 */
class Route
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var callable
     */
    private $callback;

    /**
     * @var string[]
     */
    private $parameters;

    /**
     * Route constructor.
     * @param string $name
     * @param callable $callback
     * @param array $parameters
     */
    public function __construct(string $name, callable $callback, array $parameters)
    {
        $this->name = $name;
        $this->callback = $callback;
        $this->parameters = $parameters;
    }

    /* GETTERS */

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return callable
     */
    public function getCallback(): callable
    {
        return $this->callback;
    }

    /**
     * @return string[]
     */
    public function getParams(): array
    {
        return $this->parameters;
    }
}
