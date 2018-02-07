<?php

namespace Jojotique\Framework;

/**
 * Class Renderer
 * Objet qui permet l'envoie des vues
 * @package Jojotique\Framework
 */
/**
 * Class Renderer
 * @package Jojotique\Framework
 */
class Renderer
{
    /**
     * Namespace par défaut
     */
    private const DEFAULT_NAMESPACE = '__MAIN';

    /**
     * @var array qui regroupe les chemins
     */
    private $paths = [];


    /**
     * Variable globale visiblent sur toutes les vues
     * @var array
     */
    public $globales = [];

    /**
     * Ajoute un chemin pour afficher les vues
     * Si le namespace n'est pas renseigner, c'est le namespace global qui est indiqué
     * @param string $path
     * @param null|string $namespace
     */
    public function addPath(string $path, ?string $namespace = null): void
    {
        if (is_null($namespace)) {
            $namespace = self::DEFAULT_NAMESPACE;
        }

        $this->paths[$namespace] = $path;
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
     */
    public function render(string $view, ?array $params = []): string
    {
        if ($this->hasNamespace($view)) {
            $path = $this->replaceNamespace($view) . '.php';
        } else {
            $path = $this->paths[self::DEFAULT_NAMESPACE] . DIRECTORY_SEPARATOR . $view . '.php';
        }

        ob_start();
        (!empty($this->globales)) ? extract($this->globales) : null; //Extrait les variables globales avant
        (!empty($params)) ? extract($params) : null; //car si identique ici, les écrase
        $renderer = $this; // S'injecte lui-même pour être utilisé dans les views
        require($path);
        return ob_get_clean();
    }

    /**
     * Permet d'ajouter des variables globales
     * @param string $key
     * @param mixed $value
     */
    public function addGlobal(string $key, $value): void
    {
        $this->globales[$key] = $value;
    }

    /**
     * Vérifie si le nom de la view commence par un @ et donc si elle a un namespace
     * @param string $view
     * @return bool
     */
    private function hasNamespace(string $view): bool
    {
        return $view[0] === '@';
    }

    /**
     * Récupère le namespace en supprimant le @ du nom de la view
     * @param string $view
     * @return string
     */
    private function getNamespace(string $view): string
    {
        return substr($view, 1, strpos($view, '/') - 1);
    }

    /**
     * Récupère le namespace, le supprime du nom de la view et le remplace par le chemin stocké dans $paths
     * @param string $view
     * @return string
     */
    private function replaceNamespace(string $view): string
    {
        $namespace = $this->getNamespace($view);

        return str_replace('@' . $namespace, $this->paths[$namespace], $view);
    }
}
