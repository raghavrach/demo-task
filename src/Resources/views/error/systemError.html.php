<?php
$view->extend('base.html.php');

$view['slots']->set('head_title', 'Error');

$view['slots']->start('_body_content');
?>
<div class="container">
    <div class="row">
        <?php echo App\Library\Utils\MessageUtil::showMessages([$message], 'danger'); ?>
    </div>
</div>
<?php $view['slots']->stop(); ?>