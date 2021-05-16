<?php

//===== VARIABLE ======
$moduleName     = $this->arrParam['module'];
$controllerName = $this->arrParam['controller'];
$actionName     = $this->arrParam['action'];
$linkAddNew     = URL::createLink($moduleName, $controllerName, 'form');
$filter_search  = $this->arrParam['filter_search'] ?? '';
$xhtml          = '';

//===== $THIS->ITEMS ======
foreach ($this->items as $item) {
   
    $checkbox          = Helper::showItemCheckbox($item['id']);
    $id                = Helper::highLight($item['id'], $filter_search);
    $name              = Helper::highLight($item['name'], $filter_search);
    $picture           = Helper::showPicture('moto', $item['picture']);
    $price             = number_format($item['price']);
    $sale_off          = $item['sale_off'];
    $urlChangeCategory = URL::createLink($moduleName, $controllerName, 'ajaxChangeCategory', ['id' => $item['id'], 'category_id' => 'value_new']);
    $category          = Helper::select('select-category', 'custom-select custom-select-sm', $this->slbFilterCategoryList, $item['category_id'], 'width: unset', 'data-url="' . $urlChangeCategory . '"');
    $status            = Helper::showItemStatus($item['status'], URL::createLink($moduleName, $controllerName, 'ajaxStatus', ['id' => $id, 'status' => $item['status']]), $id);
    $special           = Helper::showItemSpecial($item['special'], URL::createLink($moduleName, $controllerName, 'ajaxSpecial', ['id' => $id, 'special' => $item['special']]), $id);
    $ordering          = Helper::showItemOrdering($item['id'], $item['ordering']);
    $created           = Helper::showItemHistory($item['created_by'], $item['created']);
    $actionButton      = Helper::showActionButton($moduleName, $controllerName, $item['id']);

    $xhtml .= '
    <tr>
            <td class="text-center">' . $checkbox . '</td>
            <td class="text-center">' . $id . '</td>
            <td width="10%" class="text-wrap" style="min-width: 180px">' . $name . '</td>
            <td  style="width: 3px; padding: 3px">' . $picture . '</td>
            <td class="text-center">' . $price . ' đ</td>
            <td class="text-center">' . $sale_off . '%</td>
            <td class="text-center position-relative"> ' . $category . ' </td>                
            <td class="text-center position-relative"> ' . $status . ' </td>            
            <td class="text-center position-relative">' . $special . '</td>     
            <td class="text-center position-relative">' . $ordering . '</td>
            <td class="text-center">' . $created . '</td>
            <td class="text-center">' . $actionButton . '  </td>
    </tr>
    ';
}


$columnPost  = $this->arrParam['filter_column'];
$orderPost   = $this->arrParam['filter_column_dir'];

//===== SORT ======
$lblID       = Helper::cmsLinkSort('ID', 'id', $columnPost, $orderPost);
$lblName     = Helper::cmsLinkSort('Name', 'name', $columnPost, $orderPost);
$lblPrice    = Helper::cmsLinkSort('Price', 'price', $columnPost, $orderPost);
$lblSaleOff  = Helper::cmsLinkSort('Sale', 'sale', $columnPost, $orderPost);
$lblCategory = Helper::cmsLinkSort('Category', 'category', $columnPost, $orderPost);
$lblStatus   = Helper::cmsLinkSort('Status', 'status', $columnPost, $orderPost);
$lblSpecial  = Helper::cmsLinkSort('Special', 'special', $columnPost, $orderPost);
$lblOrdering = Helper::cmsLinkSort('Ordering', 'ordering', $columnPost, $orderPost);
$lblCreated  = Helper::cmsLinkSort('Created', 'created', $columnPost, $orderPost);
$lblModified = Helper::cmsLinkSort('Modified', 'modified', $columnPost, $orderPost);




require_once 'element/search-filter.php'
//!=================================================== END PHP =======================================================
?>


<!-- LIST -->
<div class="card card-info card-outline">
    <?php require_once 'html/header.php' ?>
    <!-- BODY -->
    <div class="card-body">
        <?php require_once 'html/control.php' ?>
        <!-- LIST CONTENT -->
        <form action="" method="post" class="table-responsive" id="form-table">
            <table class="table table-bordered table-hover text-nowrap btn-table mb-0">
                <thead>
                    <tr>
                        <th class="text-center">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="check-all">
                                <label for="check-all" class="custom-control-label"></label>
                            </div>
                        </th>
                        <th class="text-center">ID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Picture</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Sale Off</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Special</th>
                        <th class="text-center">Ordering</th>
                        <th class="text-center">Created</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?= $xhtml; ?>
                </tbody>
            </table>
        </form><!-- END LIST CONTENT -->
    </div> <!-- END BODY -->
    <?php require_once 'html/footer.php' ?>
</div>