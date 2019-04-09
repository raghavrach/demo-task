<!DOCTYPE html>
<html>
    <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <meta name="title" content="<?php $view['slots']->output('head_title') ?> | InterNations Demo" />
            <meta name="robots" content="index, follow" />

            <link rel="shortcut icon" href="/images/favicon.ico" />
            <title><?php $view['slots']->output('head_title') ?></title>
            <?php echo $view->render('partial/_common_css.html.php'); ?>
            <?php $view['slots']->output('css_assets') ?>
            <?php $view['slots']->output('js_assests') ?>
    </head>
    <body>
        <?php // Header ?>
        <?php echo $view->render('partial/_header.html.php'); ?>

        <?php // File Content ?>
        <?php $view['slots']->output('_body_content') ?>

        <?php // Footer  ?>
        <?php echo $view->render('partial/_footer.html.php', []) ?>

    </body>
</html>