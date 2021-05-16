<?php
class SliderModel extends Model
{
	private $_columns = ['id', 'name', 'picture', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering'];

	//===== __CONSTRUCT ======
	public function __construct()
	{
		parent::__construct();
		$this->setTable(TBL_SLIDER);
		$userObj 			= Session::get('user');
		$this->_userInfo 	= $userObj['info'];
	}

	//===== LIST ITEM ======
	public function listItem($arrParam, $option = null)
	{
		//===== VARIABLE ======	
		$filter_search = $arrParam['filter_search'];

		//===== QUERY ======
		$query[]	= "SELECT `id`,`name`,`picture`, `created`, `created_by`, `modified`, `modified_by`, `status`, `ordering`";
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
			if ($arrParam['key'] == 'default') {
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
				if ($arrParam['key'] == 'default') {
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
		$query = "UPDATE `$this->table` SET `status`= $status WHERE `id` IN ($ids)";
		$this->query($query);

		$result = $this->affectedRows();
		if ($result) {
			Session::set('notify', Helper::createNotify('success', 'update'));
		} else {
			Session::set('notify', Helper::createNotify('warning', 'updateError'));
		}
		return $result;
	}

	//===== DELETE ITEMS ======
	public function deleteItems($arrParam, $options = null)
	{
		// xoa trong thu muc
		require_once PATH_LIBRARY_EXT . 'Upload.php';
		$uploadObj            = new Upload();
		$id = $arrParam['id'];
		$query 		= "SELECT `picture` FROM `$this->table` WHERE `id` = $id
		";
		$name 	= $this->fetchRow($query)['picture'];
		$uploadObj->removeFile('slider', $name);
		$uploadObj->removeFile('slider', '220x147-' . $name);


		//xoa trong database
		$ids                        	      = [];
		if (isset($arrParam['id'])) $ids       = [$arrParam['id']];
		if (isset($arrParam['checkbox'])) $ids = $arrParam['checkbox'];
		$this->delete($ids);
	}

	//===== INFO ITEM ======
	public function infoItem($arrParam, $option = null)
	{
		if ($option == null) {
			$query[]    = "SELECT `id`, `name`, `picture`, `created`, `created_by`, `modified`, `modified_by`, `status`, `ordering`";
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
		require_once PATH_LIBRARY_EXT . 'Upload.php';
		$uploadObj            = new Upload();

		if ($options['task'] == 'add') {

			$params['form']['name']       = $params['form']['name'];
			$params['form']['picture']    = $uploadObj->uploadFile($params['form']['picture'], 'slider');
			$params['form']['created']    = date(DB_DATETIME_FORMAT);
			$params['form']['created_by'] = $this->_userInfo['username'];
			$params['form']['status']     = $params['form']['status'];
			$params['form']['ordering']   = $params['form']['ordering'];

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

			
			require_once PATH_LIBRARY_EXT . 'Upload.php';
			$uploadObj            = new Upload();
			

			$params['form']['name']       = $params['form']['name'];
			$params['form']['picture']    = $uploadObj->uploadFile($params['form']['picture'], 'slider');
			$params['form']['created']    = date(DB_DATETIME_FORMAT);
			$params['form']['created_by'] = $this->_userInfo['username'];
			$params['form']['status']     = $params['form']['status'];
			$params['form']['ordering']   = $params['form']['ordering'];
			if ($params['form']['picture'] == null) {
				unset($params['form']['picture']);
			} else {
				// xoa trong thu muc
				$id = $params['form']['id'];
				$query 		= "SELECT `picture` FROM `$this->table` WHERE `id` = $id";
				$name 	= $this->fetchRow($query)['picture'];
				$uploadObj->removeFile('slider', $name);
				$uploadObj->removeFile('slider', '220x147-' . $name);
			}


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
}
