<?php
namespace Jojotique\Framework\Renderer;

use Jojotique\Framework\Router\RouterTwigExtension;
use Psr\Container\ContainerInterface;
use Twig_Environment;
use Twig_Loader_Filesystem;

class TwigRendererFactory
{
    /**
     * @param ContainerInterface $container
     * @return TwigRenderer
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container)
    {
        $viewPath = $container->get('views.path');
        $loader = new Twig_Loader_Filesystem($viewPath);
        $twig = new Twig_Environment($loader, []);

        if ($container->has('twig.extensions')) {
            foreach ($container->get('twig.extensions') as $extension) {
                $twig->addExtension($extension);
            }
        }

        return new TwigRenderer($loader, $twig);
    }
}
