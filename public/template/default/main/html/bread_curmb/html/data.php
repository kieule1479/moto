<?php

$link_trang_chu   = URL::createLink('frontend', 'index', 'index');
$link_moto        = URL::createLink('frontend', 'moto', 'index');
$link_news        = URL::createLink('frontend', 'news', 'index');
$link_video        = URL::createLink('frontend', 'video', 'index');
$link_category    = URL::createLink('frontend', 'category', 'index');
$link_category_id = URL::createLink('frontend', 'moto', 'list', ['category_id' => 4]);


$model = new Model();

$query = "SELECT `id` AS `link`,`name` FROM `category` WHERE 1";
$result = $model->fetchAll($query);
foreach ($result as $key => $value) {
    $arr[$value['link']] = ['name' => $value['name'], 'link' => $value['link']];
}


$query = "SELECT `id` AS `link`,`name` FROM `moto` WHERE 1";
$result = $model->fetchAll($query);
foreach ($result as $key => $value) {
    $arrMoto[$value['link']] = ['name' => $value['name'], 'link' => $value['link']];
}



$query = "SELECT `id` AS `link`,`title` FROM `news` WHERE 1";
$result = $model->fetchAll($query);
foreach ($result as $key => $value) {
    $arrNews[$value['link']] = ['name' => $value['title'], 'link' => $value['link']];
}



$query = "SELECT `id` AS `link`,`name` FROM `video` WHERE 1";
$result = $model->fetchAll($query);
foreach ($result as $key => $value) {
    $arrVideo[$value['link']] = ['name' => $value['name'], 'link' => $value['link']];
}

// echo '<pre>';
// print_r($arrNews);
// echo '</pre>';




$arrMenu = [
    'index' => [
        "name"  => "Trang chủ",   "link"  => $link_trang_chu
    ],
    'category' => [
        "name"  => "Danh mục",
        "link"  => "$link_category",
        "child" => $arr
    ],
    'moto' => [
        "name" => "Moto",
        "link" => $link_moto,
        "child" => $arrMoto
    ],
    'news' => [
        "name" => "Tin tức",
        "link" => $link_news,
        "child" => $arrNews

    ],
    'video' => [
        "name" => "Video",
        "link" => $link_video,
        "child" => $arrVideo

    ],
    'user' => [
        "name" => "User",
        "link" => $link_moto

    ]
];

// echo '<pre>';
// print_r($arrMenu);
// echo '</pre>';
$arrBreadCrumb  = [];
foreach ($arrMenu as $keyLevelOne => $menuLevelOne) {
    $arrBreadCrumb[$keyLevelOne][]  = ['name' => $menuLevelOne['name'], 'link' => $menuLevelOne['link']];

    if (isset($menuLevelOne['child'])) {

        foreach ($menuLevelOne['child'] as $keyLevelTwo => $menuLevelTwo) {
            $arrBreadCrumb[$keyLevelTwo][]  = ['name' => $menuLevelOne['name'], 'link' => $menuLevelOne['link']];
            $arrBreadCrumb[$keyLevelTwo][]  = ['name' => $menuLevelTwo['name'], 'link' => $menuLevelTwo['link']];

            if (isset($menuLevelTwo['child'])) {

                foreach ($menuLevelTwo['child'] as $keyLevelThree => $menuLevelThree) {
                    $arrBreadCrumb[$keyLevelThree][]  = ['name' => $menuLevelOne['name'], 'link' => $menuLevelOne['link']];
                    $arrBreadCrumb[$keyLevelThree][]  = ['name' => $menuLevelTwo['name'], 'link' => $menuLevelTwo['link']];
                    $arrBreadCrumb[$keyLevelThree][]  = ['name' => $menuLevelThree['name'], 'link' => $menuLevelThree['link']];
                }
            }
        }
    }
}
$menuCurrent    = $_GET['controller'];

if (isset($_GET['category_id'])) {
    $menuCurrent    = 'category';
}
