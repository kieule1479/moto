<?php
$linkLogOut  = URL::createLink('backend', 'index', 'logout');
$linkProFile = URL::createLink('backend', 'index', 'profile');
$userObj     = Session::get('user');
$userName    = $userObj['info']['fullname'];




//!=================================================== END PHP =======================================================
?>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- LEFT NAVBAR LINKS -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul> <!-- END LEFT NAVBAR LINKS -->

    <?php  ?>
    <!-- RIGHT NAVBAR LINKS -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="public/template/admin/theme_admin/images/default-user.jpg" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline">ZendVN</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-info">
                    <img src="public/template/admin/theme_admin/images/default-user.jpg" class="img-circle elevation-2" alt="User Image">
                    <p>ZendVN <small> <?= $userName  ?>  </small></p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <a href=" <?= $linkProFile ?> " class="btn btn-default btn-flat">Profile</a>
                    <a href=" <?= $linkLogOut ?> " class="btn btn-default btn-flat float-right">Sign out</a>
                </li>
            </ul>
        </li>
    </ul> <!-- END RIGHT NAVBAR LINKS -->
</nav>