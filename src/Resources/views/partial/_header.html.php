<header>
    <nav class="header-wrapper navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="<?php echo $view['router']->path('homepage'); ?>"><h1 class="headerTitle">InterNations Demo Task</h1></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <?php if($app->getUser()){ ?>
                    <div class="loggedInUserBox ml-auto">
                        <p>Welcome! <strong><?php echo $app->getUser()->getName(); ?></strong></p>
                        <a class="btn btn-info" href="<?php echo $view['router']->path('app_manage_users'); ?>">Manage Users</a>
                        <a class="btn btn-success" href="<?php echo $view['router']->path('app_manage_groups'); ?>">Manage Groups</a>
                        <a class="btn btn-danger logOutLink" href="<?php echo $view['router']->path('app_logout'); ?>">Logout</a>
                    </div>
                <?php } ?>
                
            </disv
        </div>
    </nav>
</header>

<?php // This section is closed in footer ?>
<section class="contentBody  mt-5">