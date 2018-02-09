<?php

namespace Jojotique\Framework\Twig;

use DateTime;
use Twig_Extension;
use Twig_SimpleFilter;

/**
 * Class TimeExtension
 * @package Jojotique\Framework\Twig
 */
class TimeExtension extends Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters(): array
    {
        return [
            new Twig_SimpleFilter('ago', [$this, 'ago'], ['is_safe' => ['html']])
        ];
    }

    /**
     * Retourne le temps avec un format "Il y a X jours"
     * @param DateTime $date
     * @param string $format
     * @return string
     */
    public function ago(DateTime $date, string $format = 'd/m/Y à H:i'): string
    {
        return '<span class="timeago" datetime="' . $date->format(DateTime::ISO8601) . '">' .
            $date->format($format) .
            '</span>';
    }
}
