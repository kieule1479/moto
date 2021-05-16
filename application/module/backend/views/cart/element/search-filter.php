<?php

$inputHiddenModule     = '<input type="hidden" name="module" value="' . $moduleName . '">';
$inputHiddenController = '<input type="hidden" name="controller" value="' . $controllerName . '">';
$inputHiddenAction     = '<input type="hidden" name="action" value="' . $actionName . '">';

$moduleName     = $this->arrParam['module'];
$controllerName = $this->arrParam['controller'];
$actionName     = $this->arrParam['action'];
$linkReload     = URL::createLink($moduleName, $controllerName, $actionName);




$slbFilterGroup = Helper::select('filter_status', 'custom-select custom-select-sm mr-1', ['default' => '- Trạng thái -',0 => 'Đơn hàng mới', 1 => 'Đang xử lý', 2 =>'Hoàn tất'], $this->arrParam['filter_status'], $this->arrParam['filter_status']??'default', 'width: unset');

$arrKey = ['all' => 'Search by All', 'id' => 'Search by ID',  'info' => 'Search by Info'];
$slbKey = Helper::select('key', 'custom-select select-search-field', $arrKey, $this->arrParam['key'], 'width: unset');


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

          
            <!-- SELECT GROUP ACP  -->
            <div class="mb-1">
                <form action="" method="GET" id="filter-bar">
                    <?= $inputHiddenModule . $inputHiddenController . $inputHiddenAction ?>
                    <?= $slbFilterGroup ?>
                </form>
            </div>
            <!--END SELECT GROUP ACP-->

            <!-- SELECT NAME -->
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
            </div><!-- END SELECT NAME -->

        </div>
    </div><!-- END BODY -->
</div>