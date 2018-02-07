<?php

namespace Jojotique\Framework\Renderer;

/**
 * Interface RendererInterface
 * @package Jojotique\Framework\Renderer
 */
interface RendererInterface
{
    /**
     * Ajoute un chemin pour afficher les vues
     * Si le namespace n'est pas renseigner, c'est le namespace global qui est indiqué
     * @param string $path
     * @param null|string $namespace
     */
    public function addPath(string $path, ?string $namespace = null): void;

    /**
     * Rends une view
     * Le chemin peut être précisé avec des namespaces rajoutés via addPath
     * Ex :
     * $this->render('@blog/view'); => vue avec un namespace
     * $this->render('view'); => avec le namespace par défaut
     * @param string $view
     * @param array|null $params
     * @return string
     */
    public function render(string $view, ?array $params = []): string;

    /**
     * Ajoute des variables globales
     * @param string $key
     * @param mixed $value
     */
    public function addGlobal(string $key, $value): void;
}
