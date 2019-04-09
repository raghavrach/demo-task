<?php
$view->extend('base.html.php');

$view['slots']->set('head_title', 'Login');

$view['slots']->start('_body_content');
?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">User Credentials - Only for Demo.</div>
                <div class="panel-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th class="text-center">Role</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Password</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Admin</td>
                            <td>admin@internations-demo.com</td>
                            <td>12345</td>
                          </tr>
                          <tr>
                            <td>User</td>
                            <td>user@internations-demo.com</td>
                            <td>12345</td>
                          </tr>
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <?php 
            if(!empty($errorMessages)){
                echo App\Library\Utils\MessageUtil::showMessages($errorMessages, 'danger');
            }
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <?php if(!$app->getUser()){ ?>
                        <form class="form-horizontal" role="form" method="POST" action="<?php echo $view['router']->path('app_login'); ?>">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" class="form-control" name="login[email]" value="" />
                            </div>

                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" name="login[password]" value="" />
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Sign In</button>
                            </div>
                        </form>
                    <?php } else{
                        echo App\Library\Utils\MessageUtil::showMessages(array('You are currently logged in'), 'info');
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $view['slots']->stop(); ?>