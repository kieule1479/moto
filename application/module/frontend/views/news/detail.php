<?php


//===== DANH MUC LEFT ======
if (!isset($this->arrParam['category_id'])) {
    $class1 = 'text-dark';
} else if ($this->arrParam['category_id'] == $this->category['id']) {
    $class1 = 'my-text-primary';
}
$xhtmlCategory = '';
foreach ($this->category as $key => $value) {
    if (!isset($this->arrParam['category_id']) || $this->arrParam['category_id'] != $value['id']) {
        $class1 = 'text-dark';
    } else if ($this->arrParam['category_id'] == $value['id']) {
        $class1 = 'my-text-primary';
    }
    $xhtmlCategory .= Helper::createCategoryItem($value['id'], $value['name'], $class1);
} //===== END DANH MUC LEFT ======



//===== MOTO NOI BAT LEFT ======
$xhtmlSpecial1 = Helper::createSpecialMoto($this->specialMoto1);
$xhtmlSpecial2 = Helper::createSpecialMoto($this->specialMoto2);
//=====END MOTO NOI BAT LEFT ======


$xhtml = '';

foreach ($this->OneNews as $value) {
    $xhtml = $value['description'];
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


                        <div class="container kk123">

                            <?php echo $xhtml
                            ?>

                        </div>
                    </div>
                </div>




            </div>
        </div>
    </div>
</section>