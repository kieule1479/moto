<?php

//===== VARIABLE ======
$moduleName     = $this->arrParam['module'];
$controllerName = $this->arrParam['controller'];
$actionName     = $this->arrParam['action'];
$filter_search  = $_GET['filter_search'];
$linkForm       = URL::createLink($moduleName, $controllerName, 'form');



//===== $THIS->ITEMS ======
foreach ($this->Items as $key => $value) {

	$linkResetPas = URL::createLink($moduleName, $controllerName, 'resetPassword', ['id' => $value['id']]);
	$id           = Helper::highLightCol($value['id'], $filter_search, $this->arrParam['key'], ['id', 'all']);
	$linkDelete   = URL::createLink($moduleName, $controllerName, 'delete', ['id' => $id]);
	$linkEdit     = URL::createLink($moduleName, $controllerName, 'form', ['id' => $id]);
	$arrInfo      = [
		['name' => 'Email',  'value' => Helper::highLightCol($value['email'], $filter_search, $this->arrParam['key'], ['info', 'all'])],
		['name' => 'Họ và tên',  'value' => Helper::highLightCol($value['fullname'], $filter_search, $this->arrParam['key'], ['info', 'all'])],
		['name' => 'Số điện thoại',  'value' => Helper::highLightCol($value['telephone'], $filter_search, $this->arrParam['key'], ['info', 'all'])],
		['name' => 'Địa chỉ',  'value' => Helper::highLightCol($value['address'], $filter_search, $this->arrParam['key'], ['info', 'all'])]
	];
	$info       = Helper::showUserInfo($arrInfo);
	$status     = Helper::showItemStatus($value['status'], URL::createLink($moduleName, $controllerName, 'ajaxStatus', ['id' => $value['id'], 'status' => $value['status']]), $value['id']);
	$group      = Helper::select('select-status', 'custom-select custom-select-sm mr-1', [0 => 'Đơn hàng mới', 1 => 'Đang xử lý', 2 => 'Hoàn tất'], $value['status'], 'width: unset', 'data-id="' . $value['id'] . '"');
	$date       = Helper::formatDate(DATETIME_FORMAT, $value['date']);
	$names      = json_decode($value['names']);
	$quantities = json_decode($value['quantities']);
	$prices     = json_decode($value['prices']);
	$chiTiet    = '';
	$total = 0;
	foreach ($names as $keyN => $valueN) {
		$quantitiesL = $quantities[$keyN];
		$pricesL     = $prices[$keyN];
		$total       += $quantitiesL * $pricesL;

		$chiTiet .= sprintf('<p class="mb-0"><b>%s</b>. %s x ( %s đ x <span class="badge badge-info right" >%s</span> ) </p>', $keyN + 1, $valueN, number_format($pricesL), $quantitiesL);
	}

	$xhtml .= '	<tr>
					
					<td width="5%" class="text-center">' . $id . '</td>
					<td width="35%" class="text-left ">' . $info . '</td>
		
					<td width="15%" class="text-center position-relative">' . $group . '</td>
					<td  class="text-left">' . $chiTiet . '</td>
					<td width="15%" class="text-center">' . number_format($total) . ' đ</td>
					
					<td width="15%" class="text-center">
						
						<p class="mb-0 history-time"><i class="far fa-clock"></i> ' . $date . '</p>
					</td>
					
					<td width="15%" class="text-center">
						
						<a href="' . $linkDelete . '" class="rounded-circle btn btn-sm btn-danger btn-delete-item" title="Delete">
							<i class="fas fa-trash-alt"></i>
						</a>
					</td>
				</tr>';
}

//===== SORT ======
$lblMDH       = Helper::cmsLinkSort('Mã đơn hàng', 'id', $columnPost, $orderPost);

$columnPost  = $this->arrParam['filter_column'];
$orderPost   = $this->arrParam['filter_column_dir'];
$lblGroup    = Helper::cmsLinkSort('Trạng thái', 'group_acp', $columnPost, $orderPost);

$lblCreated  = Helper::cmsLinkSort('Created', 'created', $columnPost, $orderPost);



require_once 'element/search-filter.php';
//!=========================================== END PHP ===================================================
?>
<!-- List -->
<div class="card card-info card-outline">


	<?php require_once 'html/header.php' ?>
	<!-- BODY -->
	<div class="card-body">


		<!-- LIST CONTENT -->
		<form action="#" method="post" class="table-responsive" id="form-table">
			<table class="table table-bordered table-hover text-nowrap btn-table mb-0">
				<thead>
					<tr>

						<th class="text-center"><?php echo $lblMDH ?></th>
						<th class="text-center">Thông tin</th>

						<th class="text-center"> <?php echo $lblGroup ?> </th>
						<th class="text-center">Chi tiết</th>
						<th class="text-center">Tổng tiền</th>

						<th class="text-center"><?php echo $lblCreated ?></th>

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