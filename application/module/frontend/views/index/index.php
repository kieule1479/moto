<?php


//!=================================================== END PHP =======================================================
$linkNews = URL::createLink('frontend', 'news', 'index');

//======== SLIDER =========
$xhtmlSliders = '';
foreach ($this->sliders as $value) {
    $xhtmlSliders .= Helper::slider($value['picture']);
} //======== END SLIDER =========



//===== SAN PHAM NOI BAT ======
foreach ($this->hotProducts as $key => $hotProduct) {
    $name     = $hotProduct['name'];
    $sale_off = $hotProduct['sale_off'];
    $id       = $hotProduct['id'];
    $picture  = $hotProduct['picture'];
    $price    = $hotProduct['price'];
    $xhtmlSanPhamNoiBat .= Helper::createRowProduct($name, $sale_off, $id, $picture, $price, $hotProduct['rating']);
} //===== SAN PHAM NOI BAT ======


//===== TIEU DE DANH MUC NO BAT======
$xhtml = '';
foreach ($this->hotCategoryTitles as $key => $hotCategoryTitle) {
    if ($key == 0) {
        $xhtml .= Helper::tieuDeDanhMucNoiBat('current', $hotCategoryTitle['id'], '1', $hotCategoryTitle['name']);
    } else {
        $xhtml .= Helper::tieuDeDanhMucNoiBat('',  $hotCategoryTitle['id'], '1', $hotCategoryTitle['name']);
    }
} //=====END TIEU DE DANH MUC NO BAT ======



//===== DANH MUC NOI BAT ======
$arr = [];

$i = 0;
$j = 0;
foreach ($this->specialCategoryList as $key => $specialCategory) {

    $arr[$i]['name'] = $specialCategory['name'];
    $arr[$i]['id']   = $specialCategory['id'];

    foreach ($this->categoryInMotos as  $categoryInMoto) {
        if ($categoryInMoto['category_id'] == $specialCategory['id']) {
            $arr[$i]['motos'][$j] = $categoryInMoto;
        }
        $j++;
    }
    $i++;
}


$xhtmlMotoInCategoryList = '';
$i = 0;
foreach ($arr as $key => $value) {

    $countArr = 0;
    if (isset($value['motos'])) {
        $countArr =  count($value['motos']);
    }
    $delete = $countArr - 8;
    if ($countArr > 8) {
        foreach ($value['motos'] as $val) {
            array_splice($value['motos'], 8, $delete);
        }
    }

    $linkList = URL::createLink('frontend', 'moto', 'index', ['category_id' => $value['id']]);
    if ($key == 0) {
        $classMoto = 'active default';
    } else {
        $classMoto = '';
    }

    $xhtmlMotoInCategoryList .= '
        <div id="tab-category-' . $value['id'] . '" class="tab-content ' . $classMoto . '">
            <div class="no-slider row tab-content-inside">
    ';
    if (is_array($value['motos']) || is_object($value['motos'])) {

        foreach ($value['motos'] as  $valueB) {
            $xhtmlMotoInCategoryList .= Helper::createRowProduct($valueB['name'], $valueB['sale_off'], $valueB['id'], $valueB['picture'], $valueB['price'], $valueB['rating']);
        }
    }
    $xhtmlMotoInCategoryList .= '
                </div>
            <div class="text-center"><a href="' . $linkList . '" class="btn btn-solid">Xem tất cả</a></div>
        </div>     
    ';
} //=====END DANH MUC NOI BAT ======



//======== NEW MOTO INFO =========
foreach ($this->newMotoInfos as $newMotoInfo) {

    $id                = $newMotoInfo['id'];
    $title             = $newMotoInfo['title'];
    $short_description = $newMotoInfo['short_description'];
    $img               = $newMotoInfo['picture'];
    $link              = URL::createLink('frontend', 'news', 'detail', ['news_id' => $id]);

    $xhtmlNewMotoInfos .= '
                    <div class="itemnoidungs saovan">
                        <div class="img"><a href="' . $link . '" title="' . $title . '"><img " src="' . URL_PUBLIC . 'files/news/' . $img . '" alt="' . $title . '"></a></div>
                        <div class="kk_border">
                            <br>
                             <p class="tieude"><a href="' . $link . '" title="' . $title . '">' . $title . '</a></p>
                             <span class="mota">' . $short_description . '</span>
                             <div class="xemchitiet"><a href="' . $link . '" title="' . $title . '">Chi tiết</a></div>
                         </div>
                   </div>
                 ';
}
//======== END NEWS =========


//!================================================================================================================
?>
<!-- SLIDER  -->
<section class="p-0 my-home-slider">
    <div class="slide-1 home-slider">
        <?php echo $xhtmlSliders; ?>
    </div>
</section><!-- END SLIDER  -->


<!-- SAN PHAM NOI BAT -->
<div class="title1 section-t-space title5">
    <h2 class="title-inner1">Sản phẩm nổi bật</h2>
    <hr role="tournament6">
</div>
<section class="section-b-space p-t-0 j-box ratio_asos">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="product-4 product-m no-arrow">
                    <?php echo $xhtmlSanPhamNoiBat ?>;
                </div>
            </div>
        </div>
    </div>
</section><!-- END SAN PHAM NOI BAT -->


<?php require_once 'block/giaohang_dichvu_uudai.php' ?>


<!-- DANH MUC NOI BAT-->
<div class="title1 section-t-space title5">
    <h2 class="title-inner1">Danh mục nổi bật</h2>
    <hr role="tournament6">
</div>
<section class="p-t-0 j-box ratio_asos">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="theme-tab">
                    <ul class="tabs tab-title">
                        <?php echo $xhtml; ?>
                    </ul>
                    <div class="tab-content-cls">
                        <?php echo $xhtmlMotoInCategoryList ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--END DANH MUC NOI BAT-->


<!-- TIN TUC -->
<div class="rowx">
    <div class="rowx_content">
        <div style="border-bottom:3px solid #5fcbc4" class="title">
            <div class="titleitem _bgcolormain">

                <a title="Thông tin xe mới" class="thongtinxemoi" href=" <?php echo $linkNews ?> ">Thông tin xe mới</a>
            </div>
            <div class="clear"></div>
        </div>
        <div class="chia2" style="width:100%;float:left;">
            <div class="_2item">

                <?php echo $xhtmlNewMotoInfos ?>

            </div>
            <div class="clear"></div>

        </div>
    </div>
</div><!-- END TIN TUC -->



<!-- QUICK-VIEW MODAL POPUP START-->
<div class="modal fade bd-example-modal-lg theme-modal" id="quick-view" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content quick-view-modal">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <div class="row">
                    <div class="col-lg-6 col-xs-12">
                        <div class="quick-view-img"><img style="width:200px" src="" alt="" class="w-100 img-fluid blur-up lazyload moto-picture"></div>
                    </div>
                    <div class="col-lg-6 rtl-text">
                        <div class="product-right">
                            <h2 class="moto-name"></h2>
                            <h3 class="moto-price"><span class="sale-price"></span> <del></del></h3>
                            <div class="border-product">
                                <div class="moto-description"></div>
                            </div>
                            <div class="product-description border-product">
                                <h6 class="product-title">Số lượng</h6>
                                <div class="qty-box">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <button type="button" class="btn quantity-left-minus" data-type="minus" data-field="">
                                                <i class="ti-angle-left"></i>
                                            </button>
                                        </span>
                                        <input type="text" name="quantity" class="form-control input-number" value="1">
                                        <span class="input-group-prepend">
                                            <button type="button" class="btn quantity-right-plus" data-type="plus" data-field="">
                                                <i class="ti-angle-right"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="product-buttons" data-id="">
                                <a href="#" class="btn btn-solid mb-1 btn-add-to-cart">Chọn Mua</a>
                                <a href="" class="btn btn-solid mb-1 btn-view-moto-detail">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- QUICK-VIEW MODAL POPUP END-->