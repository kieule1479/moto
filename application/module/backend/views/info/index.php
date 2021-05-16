<?php
//===== MODULE CONTROLLER ACTION ======
$moduleName     = $this->arrParam['module'];
$controllerName = $this->arrParam['controller'];
$actionName     = $this->arrParam['action'];
$filter_search  = $_GET['filter_search'];
$linkForm       = URL::createLink($moduleName, $controllerName, 'form');

//===== $THIS->ITEMS ======
foreach ($this->Items as $key => $value) {
    $id          = Helper::highLightCol($value['id'], $filter_search, $this->arrParam['key'], ['all', 'id']);
    $linkDelete  = URL::createLink($moduleName, $controllerName, 'delete', ['id' => $id]);
    $linkEdit    = URL::createLink($moduleName, $controllerName, 'form', ['id' => $id]);
    $name        = Helper::highLightCol($value['name'], $filter_search, $this->arrParam['key'], ['all', 'name']);
    $telephone   = Helper::highLightCol($value['telephone'], $filter_search, $this->arrParam['key'], ['all', 'telephone']);
    $status      = Helper::showItemStatus($value['status'], URL::createLink('backend', 'info', 'ajaxStatus', ['id' => $id, 'status' => $value['status']]), $id);
    $ordering    = Helper::showItemOrdering($value['id'], $value['ordering']);
    $created     = Helper::formatDate(DATETIME_FORMAT, $value['created']);
    $created_by  = $value['created_by'];
    $modified    = Helper::formatDate(DATETIME_FORMAT, $value['modified']);
    $modified_by = $value['modified_by'];

    $class = ($value['id'] == 1) ? 'class = "my-read-only"' : '';
    $xhtml .= '<tr ' . $class . '>
					<td class="text-center">
						<div class="custom-control custom-checkbox">
							<input class="custom-control-input" type="checkbox" id="checkbox-' . $id . '" name="checkbox[]" value="' . $id . '">
							<label for="checkbox-' . $id . '" class="custom-control-label"></label>
						</div>
					</td>
					<td class="text-center">' . $id . '</td>
					<td class="text-center">' . $name . '</td>
					<td class="text-center">' . $telephone . '</td>
					<td class="text-center position-relative">' . $status . '</td>
					<td class="text-center position-relative">' . $ordering . '</td>
					
					<td class="text-center">
						<p class=" mb-0 history-by"><i class="color_red far fa-user"></i> ' . $created_by . '</p>
						<p class="mb-0 history-time"><i class="far fa-clock"></i> ' . $created . '</p>
					</td>
					<td class="text-center modified-' . $id . '">
						<p class="	mb-0 history-by"><i class="far fa-user"></i> ' . $modified_by . '</p>
						<p class="mb-0 history-time"><i class="far fa-clock"></i> ' . $modified . '</p>
					</td>
					<td class="text-center">
						<a href="' . $linkEdit . '" class="rounded-circle btn btn-sm btn-info" title="Edit">
							<i class="fas fa-pencil-alt"></i>
						</a>

						<a href="' . $linkDelete . '" class="rounded-circle btn btn-sm btn-danger btn-delete-item" title="Delete">
							<i class="fas fa-trash-alt"></i>
						</a>
					</td>
				</tr>';
}

//===== SORT ======
$columnPost   = $this->arrParam['filter_column'];
$orderPost    = $this->arrParam['filter_column_dir'];
$lblID        = Helper::cmsLinkSort('ID', 'id', $columnPost, $orderPost);
$lblName      = Helper::cmsLinkSort('Name', 'name', $columnPost, $orderPost);
$lblTelephone = Helper::cmsLinkSort('Telephone', 'telephone', $columnPost, $orderPost);
$lblStatus    = Helper::cmsLinkSort('Status', 'status', $columnPost, $orderPost);
$lblOrdering  = Helper::cmsLinkSort('Ordering', 'ordering', $columnPost, $orderPost);
$lblCreated   = Helper::cmsLinkSort('Created', 'created', $columnPost, $orderPost);
$lblModified  = Helper::cmsLinkSort('Modified', 'modified', $columnPost, $orderPost);


require_once 'element/search-filter.php';
//!=========================================== END PHP ===========================================
?>
<!-- LIST -->
<div class="card card-info card-outline">

    <?php require_once 'html/header.php' ?>

    <!-- BODY -->
    <div class="card-body">

        <?php require_once 'html/control.php' ?>

        <!-- LIST CONTENT -->
        <form action="#" method="post" class="table-responsive" id="form-table">
            <table class="table table-bordered table-hover text-nowrap btn-table mb-0">
                <thead>
                    <tr>
                        <th class="text-center">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="check-all">
                                <label for="check-all" class="custom-control-label"></label>
                            </div>
                        </th>
                        <th class="text-center"><?php echo $lblID ?></th>
                        <th class="text-center"><?php echo $lblName ?></th>
                        <th class="text-center"><?php echo $lblTelephone ?></th>
                        <th class="text-center"><?php echo $lblStatus ?></th>
                        <th class="text-center"><?php echo $lblOrdering ?></th>
                        <th class="text-center"><?php echo $lblCreated ?></th>
                        <th class="text-center"><?php echo $lblModified ?></th>
                        <th class="text-center"><a href="#">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $xhtml ?>
                </tbody>
            </table>
            <div>
                <input type="hidden" name="filter_column" value="name">
                <input type="hidden" name="filter_column_dir" value="asc">
            </div>
        </form><!-- END LIST CONTENT -->

    </div><!-- END BODY -->

    <?php require_once 'html/footer.php' ?>

</div>