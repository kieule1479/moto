<?php
class InfoModel extends Model
{
	private $_columns = ['id', 'name', 'group_acp', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'telephone'];

	//===== __CONSTRUCT ======
	public function __construct()
	{
		parent::__construct();
		$this->setTable(TBL_INFO);
		$userObj 			= Session::get('user');
		$this->_userInfo 	= $userObj['info'];
	}

	//===== COUNT ITEMS ======
	public function countItems($arrParam, $option = null)
	{
		//===== VARIABLE ======
		$filter_search = $arrParam['filter_search'];

		//===== QUERY ======
		$query[] = "SELECT COUNT(`id`) AS 'total'";
		$query[] = "FROM `$this->table`";
		$query[] = "WHERE `id`>0";

		//===== COUNT ======
		if ($option != null) {
			if ($option['task'] == 'count-active') {
				$query[] = "AND `status`= 1 ";
			}
			if ($option['task'] == 'count-inactive') {
				$query[] = "AND `status`= 0 ";
			}
		} else {
			//===== STATUS ======
			if ($arrParam['status'] == 'active') {
				$query[]	= "AND `status`= 1";
			}
			if ($arrParam['status'] == 'inactive') {
				$query[]	= "AND `status`= 0";
			}

			//===== FILTER_GROUP_ACP ======
			if ($arrParam['filter_group_acp'] == '1') {
				$query[]	= "AND `group_acp`= 1";
			}
			if ($arrParam['filter_group_acp'] == '0') {
				$query[]	= "AND `group_acp`= 0";
			}

			//===== FILTER_SEARCH ======
			if (isset($arrParam['filter_search'])) {
				if ($arrParam['key'] == 'all') {
					$query[]	= "AND (`name` LIKE \"%$filter_search%\" OR `id` LIKE \"%$filter_search%\") ";
				} else if ($arrParam['key'] == 'id') {
					$query[]	= "AND `id` LIKE \"%$filter_search%\"  ";
				} else if ($arrParam['key'] == 'name') {
					$query[]	= "AND `name` LIKE \"%$filter_search%\"  ";
				}
			}

			//===== FILTER_COLUMN ======
			if (!empty($arrParam['filter_column']) && !empty($arrParam['filter_column_dir'])) {
				$col		= $arrParam['filter_column'];
				$colDir 	= $arrParam['filter_column_dir'];
				$query[] 	= "ORDER BY `$col` $colDir";
			} else {
				$query[] = "ORDER BY `id` DESC";
			}
		}

		//===== QUERY ======
		$query		= implode(" ", $query);
		$result		= $this->fetchRow($query);
		return $result['total'];
	}

	//===== LIST ITEM ======
	public function listItem($arrParam, $option = null)
	{
		//===== VARIABLE ======	
		$filter_search = $arrParam['filter_search'];

		//===== QUERY ======
		$query[]	= "SELECT `id`, `name`,`telephone`, `status`, `ordering`, `created`, `created_by`, `modified`, `modified_by`";
		
		$query[]	= "FROM `$this->table`";
		$query[]	= "WHERE `id` >0";


		//===== STATUS ======
		if ($arrParam['status'] == 'active') {
			$query[]	= "AND `status`= 1";
		}
		if ($arrParam['status'] == 'inactive') {
			$query[]	= "AND `status`= 0";
		}

		//===== FILTER_GROUP_ACP ======
		if ($arrParam['filter_group_acp'] == '1') {
			$query[]	= "AND `group_acp`= 1";
		}
		if ($arrParam['filter_group_acp'] == '0') {
			$query[]	= "AND `group_acp`= 0";
		}

		//===== FILTER_SEARCH ======
		if (isset($arrParam['filter_search'])) {
			if ($arrParam['key'] == 'all') {
				$query[]	= "AND (`name` LIKE \"%$filter_search%\" OR `id` LIKE \"%$filter_search%\") ";
			} else if ($arrParam['key'] == 'id') {
				$query[]	= "AND `id` LIKE \"%$filter_search%\"  ";
			} else if ($arrParam['key'] == 'name') {
				$query[]	= "AND `name` LIKE \"%$filter_search%\"  ";
			}
		}

		//===== FILTER_COLUMN ======
		if (!empty($arrParam['filter_column']) && !empty($arrParam['filter_column_dir'])) {
			$col		= $arrParam['filter_column'];
			$colDir 	= $arrParam['filter_column_dir'];
			$query[] 	= "ORDER BY `$col` $colDir";
		} else {
			$query[] = "ORDER BY `id` ASC";
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

	//===== AJAX STATUS ======
	public function ajaxStatus($arrParam, $option = null)
	{
		$id         = $arrParam['id'];
		$modified   = date(DB_DATETIME_FORMAT);
		$modifiedBy = $this->_userInfo['username'];
		$status		= ($arrParam['status'] == 1) ? 0 : 1;
		$query 		= "UPDATE `$this->table` SET `status`= $status, `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id`= $id";
		$this->query($query);
		return [
			'id'       => $id,
			'status'   => $status,
			'link'     => URL::createLink($arrParam['module'], $arrParam['controller'], 'ajaxStatus', ['id' => $id, 'status' => $status]),
			'modified' => Helper::showItemHistory($modifiedBy, $modified),
		];
	}


	//===== AJAX ORDERING ======
	public function ajaxOrdering($params, $options = [])
	{
		$id         = $params['id'];
		$ordering   = $params['ordering'];
		$modified   = date(DB_DATETIME_FORMAT);
		$modifiedBy = $this->_userInfo['username'];
		$query      = "UPDATE `$this->table` SET `ordering` = $ordering, `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` = $id";
		$this->query($query);
		return [
			'id'       => $id,
			'modified' => Helper::showItemHistory($modifiedBy, $modified),
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

	//===== CHANGE STATUS ======
	public function changeStatus($arrParam, $option = null)
	{
		if ($option['task'] = 'active') {
			$status = ($arrParam['action'] == 'active') ? 1 : 0;
			if (!empty($arrParam['checkbox'])) {
				$ids = $this->createWhereDeleteSQL($arrParam['checkbox']);
			}
		}
		if ($option['task'] = 'inactive') {
			$status = ($arrParam['action'] == 'inactive') ? 0 : 1;
			if (!empty($arrParam['checkbox'])) {
				$ids = $this->createWhereDeleteSQL($arrParam['checkbox']);
			}
		}
		$modifiedBy = $this->_userInfo['username'];
		$modified   = date(DB_DATETIME_FORMAT);
		$query      = "UPDATE `$this->table` SET `status`= $status ,`modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` IN ($ids)";

		$this->query($query);

		$result = $this->affectedRows();
		if ($result) {
			Session::set('notify', Helper::createNotify('success', 'update'));
		} else {
			Session::set('notify', Helper::createNotify('warning', 'updateError'));
		}
		return $result;
	}


	//===== INFO ITEM ======
	public function infoItem($arrParam, $option = null)
	{
		if ($option == null) {
			$query[]    = "SELECT `name`, `status`, `telephone`,`id`";
			$query[]    = "FROM `$this->table`";
			$query[]    = "WHERE `id` = '" . $arrParam['id'] . "'";
			$query      = implode(" ", $query);
			$result     = $this->fetchRow($query);
			return $result;
		}
	}

	//===== SAVE ITEM ======
	public function saveItem($params, $options = [])
	{
		if ($options['task'] == 'add') {
			
			
			$params['form']['created']    = date(DB_DATETIME_FORMAT);
			$params['form']['created_by'] = $this->_userInfo['username'];
			$data   = array_intersect_key($params['form'], array_flip($this->_columns));
			
			$result = $this->insert($data);
			if ($result) {
				Session::set('notify', Helper::createNotify('success', 'addDataSuccess'));
			} else {
				Session::set('notify', Helper::createNotify('warning', 'addDataError'));
			}
			return $result;
		}

		if ($options['task'] == 'edit') {
			

			$params['form']['modified']    = date(DB_DATETIME_FORMAT);
			$params['form']['modified_by'] = $this->_userInfo['username'];
			$data   = array_intersect_key($params['form'], array_flip($this->_columns));
			$result = $this->update($data, [['id', $params['form']['id']]]);
			if ($result) {
				Session::set('notify', Helper::createNotify('success', 'editDataSuccess'));
			} else {
				Session::set('notify', Helper::createNotify('warning', 'addDataError'));
			}
			return $params['form']['id'];
		}
	}
}
