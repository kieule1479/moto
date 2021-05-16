<?php

$linkReload = URL::createLink($moduleName, $controllerName, $actionName);
$linkAddNew = URL::createLink($moduleName, $controllerName, 'form');

$moduleName     = $this->arrParam['module'];
$controllerName = $this->arrParam['controller'];    
$actionName     = $this->arrParam['action'];
$filter_search  = $this->arrParam['filter_search'] ?? '';


//===== $THIS->ITEMS ======
$xhtml = '';

foreach ($this->items as $item) {

   
    $checkbox     = Helper::showItemCheckbox($item['id']);
    $id           = Helper::highLight($item['id'], $filter_search);
   
    $arrInfo      = [
		['name' => 'Title',  'value' => Helper::highLightCol($item['title'], $filter_search, $this->arrParam['key'], ['info', 'all'])],
		['name' => 'Short Description',  'value' => Helper::highLightCol($item['short_description'], $filter_search, $this->arrParam['key'], ['info', 'all'])],
		['name' => 'Link',  'value' => Helper::highLightCol($item['link'], $filter_search, $this->arrParam['key'], ['info', 'all'])]
	];
	$info        = Helper::showUserInfo($arrInfo);
    $picture      = Helper::showPicture('news', $item['picture']);
    $status       = Helper::showItemStatus($item['status'], URL::createLink($moduleName, $controllerName, 'ajaxStatus', ['id' => $id, 'status' => $item['status']]), $id);
    $ordering     = Helper::showItemOrdering($item['id'], $item['ordering']);
    $created      = Helper::showItemHistory($item['created_by'], $item['created']);
    $modified     = Helper::showItemHistory($item['modified_by'], $item['modified']);
    $actionButton = Helper::showActionButton($moduleName, $controllerName, $item['id']);

    $xhtml .= '
    <tr style ="width:100%">
        <td class="text-center">' . $checkbox . '</td>
        <td class="text-center">' . $id . '</td>
        <td style ="width:30%" class="text-left">' . $info . '</td>
        <td width="10%" style="width: 3px; padding: 3px" >' . $picture . '</td>
        <td class="text-center position-relative">' . $status . '</td>
        <td class="text-center position-relative">' . $ordering . '</td>
        <td class="text-center">' . $created . '</td>
        <td class="text-center modified-' . $item['id'] . '"">' . $modified . '</td>
        <td class="text-center">' . $actionButton . '</td>
    </tr>
    ';
}

//===== SORT ======
$columnPost  = $this->arrParam['filter_column'];
$orderPost   = $this->arrParam['filter_column_dir'];

$lblID       = Helper::cmsLinkSort('ID', 'id', $columnPost, $orderPost);
$lblInfo     = Helper::cmsLinkSort('Info', 'name', $columnPost, $orderPost);
$lblStatus   = Helper::cmsLinkSort('Status', 'status', $columnPost, $orderPost);
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
        <form action="#" method="post" class="table-responsive" id="form-table">
            <table class="table table-bordered table-hover btn-table mb-0">
                <thead>
                    <tr>
                        <th class="text-center">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="check-all">
                                <label for="check-all" class="custom-control-label"></label>
                            </div>
                        </th>
                        <th class="text-center"><?php echo $lblID ?></th>
                        <th style="width:37%" class="text-center"><?php echo $lblInfo ?></th>
                        <th class="text-center">Picture</th>
                        <th class="text-center"><?php echo $lblStatus ?></th>
                        <th class="text-center"><?php echo $lblOrdering ?></th>
                        <th class="text-center"><?php echo $lblCreated ?></th>
                        <th class="text-center"><?php echo $lblModified ?></th>
                        <th class="text-center"><a href="#">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?= $xhtml; ?>
                </tbody>
            </table>
            <div>
                <input type="hidden" name="filter_column" value="name">
                <input type="hidden" name="filter_column_dir" value="asc">
            </div>
        </form> <!-- END LIST CONTENT -->
    </div><!-- END BODY -->
    <?php require_once 'html/footer.php' ?>
</div>