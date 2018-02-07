<?php
/** @var \Jojotique\Framework\Router $router */
/** @var \Jojotique\Framework\Renderer $renderer */
?>

<?= $renderer->render('header');?>

    <h1>Bienvenue à tout le monde</h1>

    <ul>
        <li><a href="<?= $router->generateUri('blog.show', ['slug' => 'post-1']); ?>">Article 1</a></li>
        <li><a href="<?= $router->generateUri('blog.show', ['slug' => 'post-2']); ?>">Article 2</a></li>
        <li><a href="<?= $router->generateUri('blog.show', ['slug' => 'post-3']); ?>">Article 3</a></li>
    </ul>


<?= $renderer->render('footer');?>