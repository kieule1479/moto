<?php
$xhtml = '';

foreach ($this->Items as $key => $value) {
    $xhtml .= Helper::showCategory($value['picture'], $value['name'], $value['id']);
}
?>
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2 class="py-2">Danh mục Category</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="ratio_asos j-box pets-box section-b-space" id="category">
    <div class="container">
        <div class="no-slider five-product row">

            <?php
            echo $xhtml;
            ?>
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
</section>
