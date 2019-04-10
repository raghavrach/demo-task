<?php
$view->extend('base.html.php');

$view['slots']->set('head_title', 'Manage Users');

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
                    <div class="panel-heading">Create A User.</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="<?php echo $view['router']->path('app_save_users'); ?>">
                            <div class="form-group">
                                <label for="email">Name:</label>
                                <input type="text" class="form-control" name="register[name]" value="" />
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" class="form-control" name="register[email]" value="" />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Add</button>
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
                <div class="panel-heading">Group Users</div>
                <div class="panel-body">
                    <?php if(!empty($groupUsers))
                   {
                    ?>
                    <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th class="text-center">#</th>  
                            <th class="text-center">User</th>
                            <th class="text-center">Email</th>
                            <?php if($view['security']->isGranted('ROLE_ADMIN')){ ?>
                                <th>&nbsp;</th>
                            <?php } ?>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        $counter = 0;
                        foreach($groupUsers as $gUser)
                        {
                            ?>
                            <tr>
                                <td><?php echo ++$counter; ?></td>
                                <td><?php echo $gUser->getName(); ?></td>
                                <td><?php echo $gUser->getEmail(); ?></td>
                                <?php if($view['security']->isGranted('ROLE_ADMIN')){ ?>
                                <td><a href="<?php echo $view['router']->path('app_unlink_users', ['userId' => $gUser->getId()]); ?>" class="btn btn-danger" onclick="confirm('<?php echo  sprintf(\App\Library\MessageConst::VAL000018, 'User'); ?>');">Delete</a></td>
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