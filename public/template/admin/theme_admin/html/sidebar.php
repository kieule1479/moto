<?php
$moduleName     = $this->arrParam['module'];
$controllerName = $this->arrParam['controller'];
$actionName     = $this->arrParam['action'];


$linkDashBoard = URL::createLink('backend', 'index', 'index');
$linkInfo = URL::createLink('backend', 'info', 'index');

$linkGroupList = URL::createLink('backend', 'group', 'index');
$linkGroupForm = URL::createLink('backend', 'group', 'form');

$linkUserList = URL::createLink('backend', 'user', 'index');
$linkUserForm = URL::createLink('backend', 'user', 'form');

$linkSliderList = URL::createLink('backend', 'slider', 'index');
$linkSliderForm = URL::createLink('backend', 'slider', 'form');

$linkCategoryList = URL::createLink('backend', 'category', 'index');
$linkCategoryForm = URL::createLink('backend', 'category', 'form');

$linkMotoList = URL::createLink('backend', 'moto', 'index');
$linkMotoForm = URL::createLink('backend', 'moto', 'form');

$linkNewsList = URL::createLink('backend', 'news', 'index');
$linkNewsForm = URL::createLink('backend', 'news', 'form');

$linkCartList = URL::createLink('backend', 'cart', 'index');




$arrMenuSidebar = [
    'dashboard' => ['data-active' => 'index', 'icon' => 'tachometer-alt icon-color', 'name' => 'Dashboard', 'link' => $linkDashBoard],
    'Info'      => ['data-active' => 'information',        'icon' => 'info-circle',           'name' => 'Information',      'link' => $linkInfo],

    'slider'     => ['data-active' => 'slider',       'icon' => 'sliders-h',          'name' => 'Slider',      'link' => '#', 'child' => [
        ['data-active' => 'index',  'icon'   => 'list-ul',  'name' => 'List',   'link' => $linkSliderList],
        ['data-active' => 'form',   'icon'  => 'edit',      'name' => 'Form',   'link' => $linkSliderForm]
    ]],

    'group'     => ['data-active' => 'group',       'icon' => 'users',          'name' => 'Group',      'link' => '#', 'child' => [
        ['data-active' => 'index',  'icon'   => 'list-ul',  'name' => 'List',   'link' => $linkGroupList],
        ['data-active' => 'form',   'icon'  => 'edit',      'name' => 'Form',   'link' => $linkGroupForm]
    ]],

    'user'     => ['data-active' => 'user',       'icon' => 'user',          'name' => 'User',      'link' => '#',
    'child' => [
        ['data-active' => 'index',  'icon'   => 'list-ul',  'name' => 'List',   'link' => $linkUserList],
        ['data-active' => 'form',   'icon'  => 'edit',      'name' => 'Form',   'link' => $linkUserForm]
    ]],

    'category'      => ['data-active' => 'category',        'icon' => 'building',  'name' => 'Category',      'link' => '#', 'child' => [
        ['data-active' => 'index',  'icon'   => 'list-ul',  'name' => 'List',   'link' => $linkCategoryList],
        ['data-active' => 'form',   'icon'  => 'edit',      'name' => 'Form',   'link' => $linkCategoryForm]
    ]],

    'moto'      => ['data-active' => 'moto',        'icon' => 'motorcycle',           'name' => 'Moto',      'link' => '#', 'child' => [
        ['data-active' => 'index',  'icon'   => 'list-ul',  'name' => 'List',   'link' => $linkMotoList],
        ['data-active' => 'form',   'icon'  => 'edit',      'name' => 'Form',   'link' => $linkMotoForm]
    ]],

    'news'      => ['data-active' => 'news',        'icon' => 'newspaper',           'name' => 'News',      'link' => '#', 'child' => [
        ['data-active' => 'index',  'icon'   => 'list-ul',  'name' => 'List',   'link' => $linkNewsList],
        ['data-active' => 'form',   'icon'  => 'edit',      'name' => 'Form',   'link' => $linkNewsForm]
    ]],
    
    'cart' => ['data-active' => 'cart', 'icon' => 'cart-plus', 'name' => 'Cart', 'link' => $linkCartList],

];

$xhtmlMenu = '';
foreach ($arrMenuSidebar as $key => $menuItem) {
    $xhtmlMenu .= Helper::menuSidebar($controllerName, $actionName, $menuItem);
}


//!=================================================== END PHP =======================================================  
?>

<aside class="main-sidebar sidebar-dark-info elevation-4">

    <!-- BRAND LOGO -->
    <a href="<?= $linkDashBoard ?> " class="brand-link">
        <img src="public/template/admin/theme_admin/images/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">ZendVN</span>
    </a> <!-- END BRAND LOGO -->

    <!-- SIDEBAR -->
    <div class="sidebar">

        <!-- SIDEBAR USER PANEL -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="public/template/admin/theme_admin/images/default-user.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Admin ZendVN</a>
            </div>
        </div><!-- END SIDEBAR USER PANEL -->

        <!-- SIDEBAR MENU -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?= $xhtmlMenu ?>
            </ul>
        </nav> <!-- END SIDEBAR MENU -->

    </div> <!-- END SIDEBAR -->

</aside>