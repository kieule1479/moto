<?php

$linkReload            = URL::createLink($moduleName, $controllerName, $actionName);
$inputHiddenModule     = '<input type="hidden" name="module" value="' . $moduleName . '">';
$inputHiddenController = '<input type="hidden" name="controller" value="' . $controllerName . '">';
$inputHiddenAction     = '<input type="hidden" name="action" value="' . $actionName . '">';

//===== SHOW FILTER BUTTON ======
$itemsStatusCount = [
    'all'      => $this->countActive + $this->countInactive,
    'active'   => $this->countActive,
    'inactive' => $this->countInactive
];
$currentFilterStatus = $this->arrParam['status'] ?? 'all';
$xhtmlFilterButton   = Helper::showFilterButton($moduleName, $controllerName, $itemsStatusCount, $currentFilterStatus);



//===== SEARCH BY ALL ======
$arrKey = ['all' => 'Search by All', 'id' => 'Search by ID',  'name' => 'Search by Name'];
$slbKey = Helper::selectKeyNoNumber('key', 'custom-select select-search-field', $arrKey, $this->arrParam['key'], 'width: unset');



//!=================================================== END PHP ========================================================
?>

<div class="card card-info card-outline">
    <!-- HEADER -->
    <div class="card-header">
        <h6 class="card-title">Search & Filter</h6>
        <div class="card-tools">

            <a href=" <?php echo $linkReload ?> " class="btn btn-tool" data-toggle="tooltip" title="" data-original-title="Reload"><i class="fas fa-sync"></i></a>

            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
        </div>
    </div><!-- END HEADER -->

    <!-- BODY -->
    <div class="card-body">
        <div class="row justify-content-between">

            <!-- 3 BUTTON -->
            <div class="mb-1">
                <?php echo $xhtmlFilterButton ?>
            </div> <!-- END 3 BUTTON -->

            <!-- SELECT GROUP ACP  -->
            <div class="mb-1">
                <form action="" method="GET" id="filter-bar">
                    <?= $inputHiddenModule . $inputHiddenController . $inputHiddenAction . $slbFilterGroupACP ?>
                </form>
            </div>
            <!--END SELECT GROUP ACP-->

            <!-- SEARCH BY ALL  -->
            <div class="mb-1 text-right">
                <div class="input-group">
                    <div class="input-group-prepend input-group-sm">
                        <?= $slbKey ?>
                    </div>
                    <form action="" method="GET" id="filter-bar2">
                        <?= $inputHiddenModule . $inputHiddenController . $inputHiddenAction ?>
                        <input type="text" class="form-control form-control-sm" name="search_value" value="<?= $filter_search ?>">
                    </form>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-sm btn-danger" id="btn-clear-search">Clear</button>
                        <button type="button" class="btn btn-sm btn-info" id="btn-search">Search</button>
                    </div>
                </div>
            </div><!-- SEARCH BY ALL  -->

        </div>
    </div><!-- END BODY -->
</div>