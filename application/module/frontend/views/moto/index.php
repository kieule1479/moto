<?php

//===== DANH MUC LEFT ======
if (!isset($this->arrParam['category_id'])) {
    $class1 = 'text-dark';
} else if ($this->arrParam['category_id'] == $this->category['id']) {
    $class1 = 'my-text-primary';
}
$xhtmlCategory = '';
foreach ($this->categoryList as $key => $category) {
    if (!isset($this->arrParam['category_id']) || $this->arrParam['category_id'] != $category['id']) {
        $class1 = 'text-dark';
    } else if ($this->arrParam['category_id'] == $category['id']) {
        $class1 = 'my-text-primary';
    }
    $xhtmlCategory .= Helper::createCategoryItem($category['id'], $category['name'], $class1);
} //===== END DANH MUC LEFT ======


//===== MOTO NOI BAT LEFT ======
$xhtmlSpecial1 = Helper::createSpecialMoto($this->specialMoto1);
$xhtmlSpecial2 = Helper::createSpecialMoto($this->specialMoto2);
//=====END MOTO NOI BAT LEFT ======



//===== MOTO NOI BAT RIGHT ======
$message = '';
$xhtmlMotoInCategory = '';
$searchValue = $_GET['search_moto'];

if (!empty($this->motoInCategory) || !empty($this->allMoto)) {

    if (!isset($this->arrParam['category_id'])) {
        foreach ($this->allMoto as $key => $value) {


            $id = $value['id'];
            $xhtmlMotoInCategory .= '<div class="col-xl-3 col-6 col-grid-box">';
            $xhtmlMotoInCategory .= Helper::createRowProduct($value['name'], $value['sale_off'], $value['id'], $value['picture'], $value['price'], $value['rating'], '', $searchValue);
            $xhtmlMotoInCategory .= '</div>';
        }
    } else {

        foreach ($this->motoInCategory as $key => $value) {

            $id = $value['id'];
            $xhtmlMotoInCategory .= '<div class="col-xl-3 col-6 col-grid-box">';
            $xhtmlMotoInCategory .= Helper::createRowProduct($value['name'], $value['sale_off'], $value['id'], $value['picture'], $value['price'], $value['rating'],'', $searchValue);
            $xhtmlMotoInCategory .= '</div>';
        }
    }
} else {
    $message = "&nbsp &nbsp Dữ liệu đang được cập nhật";
} //===== END MOTO NOI BAT RIGHT ======


//======== SORT =========
$hidden = '';
$category_id = $_GET["category_id"] ?? '';
if (isset($_GET["category_id"])) {
    $hidden = '<input type="hidden" name="category_id" value="' . $category_id . '">';
    echo $hidden;
}

$arr = [
    ['key' => 'default', 'value' => ' - Sắp xếp - '],
    ['key' => 'price_asc', 'value' => 'Giá tăng dần'],
    ['key' => 'price_desc', 'value' => 'Giá giảm dần'],
    ['key' => 'latest', 'value' => 'Mới nhất'],

];

$valueSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

foreach ($arr as $value) {
    $selected = '';
    if ($value['key'] == $valueSort) {
        $selected = 'selected';
    }
    $xhtmlSelect .= sprintf(
        '<option value="%s" %s> %s </option>',
        $value['key'],
        $selected,
        $value['value'],
    );
} //======== SORT =========

//!=================================================== END PHP =======================================================
?>



<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2 class="py-2">Tất cả Moto</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="section-b-space j-box ratio_asos">
    <div class="collection-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 collection-filter">
                    <!-- side-bar colleps block stat -->
                    <div class="collection-filter-block">
                        <!-- brand filter start -->
                        <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> back</span></div>
                        <div class="collection-collapse-block open">
                            <h3 class="collapse-block-title">Danh mục</h3>
                            <div class="collection-collapse-block-content">
                                <div class="collection-brand-filter">
                                    <?php echo $xhtmlCategory ?>
                                    <div class="custom-control custom-checkbox collection-filter-checkbox pl-0 text-center">
                                        <span class="text-dark font-weight-bold" id="btn-view-more">Xem thêm</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="theme-card">
                        <h5 class="title-border">Moto nổi bật</h5>
                        <div class="offer-slider slide-1">
                            <?php echo $xhtmlSpecial1 ?>
                            <?php echo $xhtmlSpecial2 ?>
                        </div>
                    </div>
                    <!-- silde-bar colleps block end here -->
                </div>
                <div class="collection-content col">
                    <div class="page-main-content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="collection-product-wrapper">
                                    <div class="product-top-filter">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="filter-main-btn">
                                                    <span class="filter-btn btn btn-theme"><i class="fa fa-filter" aria-hidden="true"></i> Filter</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="product-filter-content">
                                                    <div class="collection-view">
                                                        <ul>
                                                            <li><i class="fa fa-th grid-layout-view"></i></li>
                                                            <li><i class="fa fa-list-ul list-layout-view"></i></li>
                                                        </ul>
                                                    </div>
                                                    <div class="collection-grid-view">
                                                        <ul>
                                                            <li class="my-layout-view" data-number="2">
                                                                <img src="<?php echo $this->_dirImg ?>/icon/2.png" alt="" class="product-2-layout-view">
                                                            </li>
                                                            <li class="my-layout-view" data-number="3">
                                                                <img src="<?php echo $this->_dirImg ?>/icon/3.png" alt="" class="product-3-layout-view">
                                                            </li>
                                                            <li class="my-layout-view active" data-number="4">
                                                                <img src="<?php echo $this->_dirImg ?>/icon/4.png" alt="" class="product-4-layout-view">
                                                            </li>
                                                            <li class="my-layout-view" data-number="6">
                                                                <img src="<?php echo $this->_dirImg ?>/icon/6.png" alt="" class="product-6-layout-view">
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-page-filter">
                                                        <form action="" id="sort-form" method="GET">

                                                            <select id="sort" name="sort">
                                                                <?php echo $xhtmlSelect ?>
                                                            </select>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-wrapper-grid" id="my-product-list">
                                        <div class="row margin-res">
                                            <?php echo $message . $xhtmlMotoInCategory ?>
                                        </div>
                                    </div>
                                    <div class="product-pagination">
                                        <div class="theme-paggination-block">
                                            <div class="container-fluid p-0">
                                                <div class="row">
                                                    <div class="col-xl-6 col-md-6 col-sm-12">
                                                        <nav aria-label="Page navigation">
                                                            <nav>

                                                                <?= $this->pagination->showPaginationAdmin(); ?>
                                                            </nav>
                                                        </nav>
                                                    </div>
                                                    <div class="col-xl-6 col-md-6 col-sm-12">
                                                        <div class="product-search-count-bottom">
                                                            <h5>Showing Items 1- <?= $this->pagination->getTotalItemsPerPage() ?> of <?php echo $this->pagination->getCurrentPage() ?></h5>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade bd-example-modal-lg theme-modal" id="quick-view" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content quick-view-modal">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <div class="row">
                    <div class="col-lg-6 col-xs-12">
                        <div class="quick-view-img"><img src="" alt="" class="w-100 img-fluid blur-up lazyload moto-picture"></div>
                    </div>
                    <div class="col-lg-6 rtl-text">
                        <div class="product-right">
                            <h2 class="moto-name"></h2>
                            <h3 class="moto-price"><del class="new-moto-price"></del></h3>
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
                            <div class="product-buttons" data-id=<?php echo $id ?>>
                                <a href="#" class="btn btn-solid mb-1 btn-add-to-cart">Chọn Mua</a>
                                <a href="item.html" class="btn btn-solid mb-1 btn-view-moto-detail">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>