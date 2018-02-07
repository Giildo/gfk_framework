<?= $renderer->render('header', ['title' => $slug]);?>

<h1>Article <?= $slug; ?></h1>

<?= $renderer->render('footer'); ?>