<?php
class CartModel extends Model
{
	private $_columns = ['id', 'username', 'email', 'fullname', 'password', 'created', 'created_by', 'modified', 'modified_by', 'register_date', 'register_ip', 'status', 'ordering', 'group_id'];

	//===== __CONSTRUCT ======
	public function __construct()
	{
		parent::__construct();
		$this->setTable(TBL_CART);
		$userObj 			= Session::get('user');
		$this->_userInfo 	= $userObj['info'];
	}

	//===== LIST ITEM ======
	public function listItem($arrParam, $option = null)
	{
		//===== VARIABLE ======
		$filter_search = $arrParam['filter_search'];


		//===== QUERY ======
		$query[]	= "SELECT `c`.`id`, `u`.`email`, `u`.`fullname`, `u`.`telephone`, `u`.`address`, `c`.`status`, `c`.`date`, `c`.`names`, `c`.`quantities`, `c`.`prices`";
		$query[]	= "FROM `cart` AS `c` LEFT JOIN `user` AS `u` ON `c`.`username` = `u`.`username`";
		$query[]	= "WHERE `c`.`id` <> ''";

		//===== STATUS ======
		if ($arrParam['filter_status'] == '1') {
			$query[]	= "AND `c`.`status`= 1";
		} else if ($arrParam['filter_status'] == '0') {
			$query[]	= "AND `c`.`status`= 0";
		} else if ($arrParam['filter_status'] == '2') {
			$query[]	= "AND `c`.`status`= 2";
		}


		//===== FILTER_SEARCH ======
		if (isset($arrParam['filter_search'])) {
			if ($arrParam['key'] == 'all') {
				$query[]	= "AND (`u`.`email` LIKE \"%$filter_search%\" OR
									 `c`.`id` LIKE \"%$filter_search%\" OR 
									 `u`.`telephone` LIKE \"%$filter_search%\" OR 
									 `u`.`address` LIKE \"%$filter_search%\") ";
			} else if ($arrParam['key'] == 'id') {
				$query[]	= "AND `c`.`id` LIKE \"%$filter_search%\"  ";
			} else if ($arrParam['key'] == 'info') {

				$query[]	= "AND (`u`.`email` LIKE \"%$filter_search%\" OR
									`c`.`id` LIKE \"%$filter_search%\" OR 
									`u`.`telephone` LIKE \"%$filter_search%\" OR 
									`u`.`address` LIKE \"%$filter_search%\") ";
			}
		}

		//===== FILTER_COLUMN ======
		if (!empty($arrParam['filter_column']) && !empty($arrParam['filter_column_dir'])) {
			$col		= $arrParam['filter_column'];
			$colDir 	= $arrParam['filter_column_dir'];
			$query[] 	= "ORDER BY `$col` $colDir";
		} else {
			$query[] = "ORDER BY `date` DESC";
		}

		//===== PAGINATION ======
		$pagination         = $arrParam['pagination'];
		$totalItemsPerPage  = $pagination['totalItemsPerPage'];
		if ($totalItemsPerPage > 0) {
			$position   = ($pagination['currentPage'] - 1) * $totalItemsPerPage;
			$query[]    = "LIMIT $position, $totalItemsPerPage";
		}

		//===== QUERY ======
		$query		= implode(" ", $query);

		$result		= $this->fetchAll($query);

		return $result;
	}



	//===== COUNT ITEMS ======
	public function countItems($arrParam, $option = null)
	{
		//===== VARIABLE ======
		$filter_search = $arrParam['filter_search'];


		//===== QUERY ======
		$query[] = "SELECT COUNT(`c`.`id`) AS 'total'";
		$query[]	= "FROM `cart` AS `c` LEFT JOIN `user` AS `u` ON `c`.`username` = `u`.`username`";
		$query[] = "WHERE `c`.`id`<>''";


		//===== STATUS ======
		if ($arrParam['filter_status'] == '1') {
			$query[]	= "AND `c`.`status`= 1";
		} else if ($arrParam['filter_status'] == '0') {
			$query[]	= "AND `c`.`status`= 0";
		} else if ($arrParam['filter_status'] == '2') {
			$query[]	= "AND `c`.`status`= 2";
		}

		//===== FILTER_SEARCH ======
		if (isset($arrParam['filter_search'])) {
			if ($arrParam['key'] == 'all') {
				$query[]	= "AND (`u`.`email` LIKE \"%$filter_search%\" OR
								 `c`.`id` LIKE \"%$filter_search%\" OR 
								 `u`.`telephone` LIKE \"%$filter_search%\" OR 
								 `u`.`address` LIKE \"%$filter_search%\") ";
			} else if ($arrParam['key'] == 'id') {
				$query[]	= "AND `c`.`id` LIKE \"%$filter_search%\"  ";
			} else if ($arrParam['key'] == 'info') {

				$query[]	= "AND (`u`.`email` LIKE \"%$filter_search%\" OR
								`c`.`id` LIKE \"%$filter_search%\" OR 
								`u`.`telephone` LIKE \"%$filter_search%\" OR 
								`u`.`address` LIKE \"%$filter_search%\") ";
			}
		}
		if (!empty($arrParam['filter_column']) && !empty($arrParam['filter_column_dir'])) {
			$col		= $arrParam['filter_column'];
			$colDir 	= $arrParam['filter_column_dir'];
			$query[] 	= "ORDER BY `$col` $colDir";
		} else {
			$query[] = "ORDER BY `c`.`id` DESC";
		}


		//===== QUERY ======
		$query		= implode(" ", $query);
		$result		= $this->fetchRow($query);
		return $result['total'];
	}

	//===== ITEM IN SELECT BOX ======
	public function itemInSelectBox($arrParam, $options = null)
	{
		$query  = "SELECT `id`, `status`AS `name` FROM `" . TBL_CART . "`";
		$result = $this->fetchPairs($query);

		if ($options['task'] == 'add_default') {
			$result = ['default' => '- Select Group ID -'] + $result;
		}
		return $result;
	}




	//===== AJAX CHANGE GROUP  ======
	public function ajaxChangeStatus($arrParam, $option = null)
	{
		$id         = $arrParam['id'];
		$date   = date(DB_DATETIME_FORMAT);

		$status   = $arrParam['status'];
		$query      = "UPDATE `$this->table` SET `status`= '$status' , `date` = '$date' WHERE `id`= '$id'";
		$this->query($query);
		return [
			'id' => $id,
			'status' => $status,
			'link' => URL::createLink($arrParam['module'], $arrParam['controller'], 'ajaxChangeStatus', ['id' => $id, 'status' => $status]),
			//'modified'  => Helper::showItemHistory($modifiedBy, $modified),
		];
	}

	//===== DELETE ITEMS ======
	public function deleteItems($arrParam, $options = null)
	{
		$ids                        	      = [];
		if (isset($arrParam['id'])) $ids       = [$arrParam['id']];
		if (isset($arrParam['checkbox'])) $ids = $arrParam['checkbox'];
		$this->delete($ids);

		$result = $this->affectedRows();
		if ($result) {
			Session::set('notify', Helper::createNotify('success', 'deleteSuccess'));
		} else {
			Session::set('notify', Helper::createNotify('warning', 'deleteError'));
		}
		return $result;
	}
}
