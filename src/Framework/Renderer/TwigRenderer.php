<?php

namespace Jojotique\Framework\Renderer;

use Exception;
use Twig_Environment;
use Twig_Loader_Filesystem;

/**
 * Class TwigRenderer
 * @package Jojotique\Framework\Renderer
 */
class TwigRenderer implements RendererInterface
{
    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @var Twig_Loader_Filesystem
     */
    private $loader;

    /**
     * TwigRenderer constructor.
     * @param Twig_Loader_Filesystem $loader
     * @param Twig_Environment $twig
     */
    public function __construct(Twig_Loader_Filesystem $loader, Twig_Environment $twig)
    {
        $this->loader = $loader;
        $this->twig = $twig;
    }

    /**
     * Ajoute un chemin pour afficher les vues
     * Si le namespace n'est pas renseigner, c'est le namespace global qui est indiqué
     * @param string $path
     * @param null|string $namespace
     * @throws \Twig_Error_Loader
     */
    public function addPath(string $path, ?string $namespace = null): void
    {
        $this->loader->addPath($path, $namespace);
    }

    /**
     * Rends une view
     * Le chemin peut être précisé avec des namespaces rajoutés via addPath
     * Ex :
     * $this->render('@blog/view'); => vue avec un namespace
     * $this->render('view'); => avec le namespace par défaut
     * @param string $view
     * @param array|null $params
     * @return string
     * @throws Exception
     */
    public function render(string $view, ?array $params = []): string
    {
        return $this->twig->render($view . '.twig', $params);
    }

    /**
     * Ajoute des variables globales
     * @param string $key
     * @param mixed $value
     */
    public function addGlobal(string $key, $value): void
    {
        $this->twig->addGlobal($key, $value);
    }
}
