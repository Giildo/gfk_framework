<?php

namespace Jojotique\Framework\Twig;

use Twig_Extension;
use Twig_SimpleFilter;

/**
 * Extensions pour les textes sur Twig
 *
 * Class TextExtension
 * @package Jojotique\Framework\Twig
 */
class TextExtension extends Twig_Extension
{
    /**
     * @return array|\Twig_Filter[]
     */
    public function getFilters(): array
    {
        return [
            new Twig_SimpleFilter('excerpt', [$this, 'excerpt'])
        ];
    }

    /**
     * Renvoie l'extrait du contenu
     *
     * @param string $content
     * @param int $maxLength
     * @return string
     */
    public function excerpt(string $content, int $maxLength = 100): string
    {
        if (mb_strlen($content) > $maxLength) {
            $excerpt = mb_substr($content, 0, $maxLength);
            $lastSpace = mb_strrpos($excerpt, ' ');
            return $excerpt = mb_substr($excerpt, 0, $lastSpace) . '...';
        }

        return $content;
    }
}
