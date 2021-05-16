<?php
$xhtml = '';

foreach ($this->news as $value) {
   
    $id                = $value['id'];
    $title             = $value['title'];
    $short_description = $value['short_description'];
    $link              = URL::createLink('frontend', 'news', 'detail', ['news_id'=>$id]);
    $img               = $value['picture'];


    $xhtml .=
        '<div class="itemnoidung">
        <div class="img"><a title="' . $title . '" href="' . $link . '"><img width="100%" alt="' . $title . '" src="' . URL_PUBLIC . 'files/news/' . $img . '"></a></div>

        <p class="tieude kk11"><a title="' . $title . '" href="'.$link.'">' . $title . '</a></p>
        <span class="mota">' . $short_description . ' </span>
        <div class="xemchitiet1"><a title="Yamaha Fazer-25 hoàn toàn mới khám phá chuyến hành trình mà động cơ 249cc mang lại" href="'.$link.'">Chi tiết</a>
        </div>
        <div class="clear"></div>
    </div>';
}
?>

<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2 class="py-2">Thông tin xe mới</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">

    <?php echo $xhtml ?>

</div>