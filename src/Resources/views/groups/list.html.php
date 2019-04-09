<?php
$view->extend('base.html.php');

$view['slots']->set('head_title', 'Manage Groups');

$view['slots']->start('_body_content');
?>
<div class="container">
    <div class="row">
        <?php if($view['security']->isGranted('ROLE_ADMIN')){ ?>
            <div class="col-md-4">
                <?php if(!empty($errorMessages)){
                    echo App\Library\Utils\MessageUtil::showMessages($errorMessages, 'danger');
                }
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><?php echo $formBlockTitle; ?></div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="">
                            <?php echo $view['form']->widget($form['_token']); ?>
                            <div class="form-group">
                                <?php echo $view['form']->label($form['name']); ?>
                                <?php echo $view['form']->widget($form['name']); ?>
                                <?php echo $view['form']->errors($form['name']); ?>
                            </div>
                            <div class="form-group">
                                <?php echo $view['form']->label($form['users']); ?>
                                <?php echo $view['form']->widget($form['users']); ?>
                                <?php echo $view['form']->errors($form['users']); ?>
                            </div>
                            <div class="form-group">
                                <?php echo $view['form']->widget($form['save']); ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="col-md-8">
            <?php if(!empty($successMessages)){
                echo App\Library\Utils\MessageUtil::showMessages($successMessages, 'success');
            }
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">Groups</div>
                <div class="panel-body">
                    <?php if(!empty($groups))
                   {
                    ?>
                    <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th class="text-center">#</th>  
                            <th class="text-center">Name</th>
                            <th class="text-center">Group User</th>
                            <?php if($view['security']->isGranted('ROLE_ADMIN')){ ?>
                            <th>&nbsp;</th>
                            <?php } ?>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        $counter = 0;
                        foreach($groups as $group)
                        {
                            ?>
                            <tr>
                                <td><?php echo ++$counter; ?></td>
                                <td><?php echo $group->getName(); ?></td>
								<td>
                                    <?php if($group->getUsers()){ 
                                        foreach($group->getUsers() as $user){
                                            ?><p class="subInfo"><?php echo $user->getName(); ?></p><?php
                                        }
                                    }
                                    ?>
                                </td>
                                <?php if($view['security']->isGranted('ROLE_ADMIN')){ ?>
                                <td>
                                    <a href="<?php echo $view['router']->path('app_edit_groups', array('groupId' => $group->getId())); ?>" class="btn btn-primary">Edit</a>
                                    <a href="<?php echo $view['router']->path('app_unlink_groups', array('groupId' => $group->getId())); ?>" class="btn btn-danger">Delete</a>
                                </td>
                                <?php } ?>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php
                    } else{
                        echo App\Library\Utils\MessageUtil::showMessages([App\Library\MessageConst::VAL000007], 'info');
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $view['slots']->stop(); ?>