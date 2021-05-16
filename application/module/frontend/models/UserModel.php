<?php
class UserModel extends Model
{
	private $_columns = ['id', 'username', 'email', 'fullname', 'password', 'created', 'created_by', 'modified', 'modified_by', 'register_date', 'register_ip', 'status', 'ordering', 'group_id'];

	//===== __CONSTRUCT ======
	public function __construct()
	{
		parent::__construct();
		$this->setTable(TBL_USER);
		$userObj 			= Session::get('user');
		$this->_userInfo 	= $userObj['info'];
	}

	//===== LIST ITEM ======
	public function listItem($arrParam, $option = null)
	{
		if ($option['task'] == 'motos_in_cart') {
			$cart	= Session::get('cart');
			$result	= [];
			if (!empty($cart)) {

				$ids	= "(";
				foreach ($cart['quantity'] as $key => $value) $ids .= "'$key', ";
				$ids	.= " '0')";

				$query[]	= "SELECT `b`.`id`, `b`.`name`, `b`.`picture`, `b`.`category_id`,`b`.`price`,  `c`.`name` AS `category_name`";
				$query[]	= "FROM `" . TBL_moto . "` AS `b`, `" . TBL_CATEGORY . "` AS `c`";
				$query[]	= "WHERE `b`.`status`  = 1 AND  `c`.`id` = `b`.`category_id` AND `b`.`id` IN $ids";
				$query[]	= "ORDER BY `b`.`ordering` ASC";
				$query		= implode(" ", $query);

				$result		= $this->fetchAll($query);
				foreach ($result as $key => $value) {
					$result[$key]['quantity']	= $cart['quantity'][$value['id']];


					$result[$key]['price']         = $result[$key]['price'];
					$result[$key]['totalprice']    = $result[$key]['price'] * ($result[$key]['quantity']);
				}
			}
			if ($option['task'] == 'add-to-cart') {
				$cart = Session::get('cart');
				$id   = $arrParam['id'];

				$query[]       = "SELECT `price`,`sale_off`";
				$query[]       = "FROM `moto`";
				$query[]       = "WHERE `id` = '$id' ";
				$query  = implode(" ", $query);
				$result = $this->fetchRow($query);

				$salePrice = ($result['price']  - ($result['price'] * $result['sale_off'] / 100));
				return [
					'id' => $id,
					'salePrice'	=> $salePrice
				];
			}
			return $result;
		}

		if ($option['task'] == 'history_cart') {

			$username	= $this->_userInfo['username'];
			$query[]	= "SELECT `id`, `motos`, `prices`, `quantities`, `names`, `pictures`, `status`, `date`";
			$query[]	= "FROM `" . TBL_CART . "`";
			$query[]	= "WHERE `username` = '$username'";
			$query[]	= "ORDER BY `date` ASC";
			$query		= implode(" ", $query);
			$result		= $this->fetchAll($query);

			return $result;
		}
		if ($option['task'] == 'account') {

			$username	= $this->_userInfo['username'];
			$query[]	= "SELECT `c`.`id`, `u`.`email`, `u`.`fullname`, `u`.`telephone`, `u`.`address`, `c`.`status`, `c`.`date`, `c`.`names`, `c`.`quantities`, `c`.`prices`";
			$query[]	= "FROM `cart` AS `c` LEFT JOIN `user` AS `u` ON `c`.`username` = `u`.`username`";
			$query[]	= "WHERE `c`.`username` = '$username'";
			$query[]	= "ORDER BY `date` ASC";
			$query		= implode(" ", $query);

			$result		= $this->fetchRow($query);

			return $result;
		}
	}


	//===== COUNT ITEMS ======
	public function countItems($arrParam, $option = null)
	{
		//===== VARIABLE ======
		$filter_search = $arrParam['filter_search'];
		$filter_group_id = $arrParam['filter_group_id'];

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
			if ($arrParam['status'] == 'active') {
				$query[]	= "AND `status`= 1";
			}
			if ($arrParam['status'] == 'inactive') {
				$query[]	= "AND `status`= 0";
			}
			if (isset($arrParam['filter_group_id']) && $arrParam['filter_group_id'] != 'default') {
				$query[]	= "AND `group_id`= '$filter_group_id'";
			}

			if (isset($arrParam['filter_search'])) {
				if ($arrParam['key'] == 'default') {
					$query[]	= "AND (`username` LIKE \"%$filter_search%\" OR `id` LIKE \"%$filter_search%\" OR `email` LIKE \"%$filter_search%\" OR `fullname` LIKE \"%$filter_search%\") ";
				} else if ($arrParam['key'] == 'id') {
					$query[]	= "AND `id` LIKE \"%$filter_search%\"  ";
				} else if ($arrParam['key'] == 'info') {

					$query[]	= "AND (`username` LIKE \"%$filter_search%\" OR `email` LIKE \"%$filter_search%\" OR `fullname` LIKE \"%$filter_search%\" )";
				}
			}

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

	//===== ITEM IN SELECT BOX ======
	public function itemInSelectBox($arrParam, $options = null)
	{
		$query  = "SELECT `id`, `name` FROM `" . TBL_GROUP . "`";
		$result = $this->fetchPairs($query);
		if ($options['task'] == 'add-default') {
			$result = ['default' => '- Select Group -'] + $result;
		}
		return $result;
	}


	//===== INFO ITEM ======
	public function infoItem($arrParam, $option = null)
	{
		$id = $_SESSION['user']['info']['id'];

		if ($option == null) {
			$query[]       = "SELECT `id`, `username`, `email`, `fullname`, `password`, `created`, `created_by`, `modified`, `modified_by`, `register_date`, `register_ip`, `status`, `ordering`, `group_id`";
			$query[]       = "FROM `$this->table`";
			$query[]       = "WHERE `email` = '" . $arrParam['form']['email'] . "'";
			$query  = implode(" ", $query);
			$result = $this->fetchRow($query);
			return $result;
		}
		if ($option['task'] == 'info_user') {

			$query[]       = "SELECT `id`, `email`, `fullname`,`telephone`, `address`";
			$query[]       = "FROM `$this->table`";
			$query[]       = "WHERE `id` = $id";
			$query  = implode(" ", $query);

			$result = $this->fetchRow($query);
			return $result;
		}
	}


	//===== SAVE ITEM ======
	public function saveItem($params, $options = [])
	{
		if ($options['task'] == 'user_register') {
			$params['form']['created']       = date(DB_DATETIME_FORMAT);
			$params['form']['password']      = md5($params['form']['password']);
			$params['form']['created_by']    = 1;
			$params['form']['group_id']      = 0;
			$params['form']['register_date'] = date(DB_DATETIME_FORMAT);
			$params['form']['register_ip']   = $_SERVER['REMOTE_ADDR'];
			$params['form']['status']        = 0;
			$data                		    = array_intersect_key($params['form'], array_flip($this->_columns));


			$result = $this->insert($data);

			return $result;
		}

		if ($options['task'] == 'edit') {

			$params['form']['modified'] = date(DB_DATETIME_FORMAT);
			$params['form']['modified_by'] = 1;

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

	//===== AJAX CART ======
	public function ajaxCart($arrParam)
	{
		// Session::delete('cart');
		// die('<h3>Pause</h3>');	
		$sl     = $arrParam['sl'];
		$id     = $arrParam['id'];
		$cart   = Session::get('cart');
		$motoID = $id;


		$query  = "SELECT `id`,`name`,`picture`,`price`,`sale_off` FROM `moto` WHERE `id` = '$id'";
		$data   = $this->fetchRow($query);
		//$quantity = $this->_arrParam['quantity'];
		$newPrice = ($data['price'] - ($data['price'] * $data['sale_off'] / 100));
		if (empty($cart)) { // chua ton tai cart
			$cart['quantity'][$motoID]   = 1;
			$cart['price'][$motoID]      = $newPrice;

			// $cart['name'][$motoID]       = $data['name'];
			// $cart['picture'][$motoID]    = $data['picture'];
			// $cart['id'][$motoID]         = $data['id'];
			// $cart['totalPrice'][$motoID] = $data['id'];

		} else { // da ton tai card

			if (key_exists($motoID, $cart['quantity'])) {
				$slCu = $cart['quantity'][$motoID];
				$cart['quantity'][$motoID] 	= $slCu + $sl;
				$cart['price'][$motoID]     = $newPrice * $cart['quantity'][$motoID];
				// $cart['name'][$motoID]      = $data['name'];
				// $cart['picture'][$motoID]   = $data['picture'];
				// $cart['id'][$motoID]        = $data['id'];
			} else {
				$cart['quantity'][$motoID] = $sl;
				$cart['price'][$motoID]    = $newPrice;
				// $cart['name'][$motoID]     = $data['name'];
				// $cart['picture'][$motoID]  = $data['picture'];
				// $cart['id'][$motoID]       = $data['id'];
			}
		}
		$badge = array_sum($cart['quantity']);
		Session::set('cart', $cart);

		return ['id' => $id, 'picture' => $data['picture'], 'name' => $data['name'], 'badge' => $badge];
	}
	//===== AJAX DELETE ======
	public function ajaxDelete($arrParam)
	{
		//Session::delete('cart');	

		$id     = $arrParam['id'];
		$cart   = Session::get('cart');


		Session::delete('cart', $id);



		$badge = array_sum($cart['quantity']);
		//Session::set('cart', $cart);
		return ['id' => $id, 'badge' => $badge];
	}

	//===== CHANGE USER ======

	public function changeUser($params)
	{
		// echo '<pre>';
		// print_r($params);
		// echo '</pre>';

		$fullname = $params['form']['fullname'];
		$phone    = $params['form']['phone'];
		$address  = $params['form']['address'];
		$id       = $params['form']['id'];
		$query    = "UPDATE `user` SET `fullname`= '$fullname', `telephone` = '$phone', `address` = '$address' WHERE `id`= $id";

		// echo '<pre>';
		// print_r($query);
		// echo '</pre>';
		// die('<h3>Pause</h3>');
		$result   = $this->query($query);
	}

	//===== SAVE ======
	public function save($params, $options = NULL)
	{

		if ($options['task'] == 'submit_cart') {

			$cart       		= $params['form'];
			$data['id']         = $this->randomString(7);
			$data['motos']      = json_encode(array_values($cart['moto_id']));
			$data['username']   = $this->_userInfo['username'];
			$data['prices']     = json_encode(array_values($cart['price']));
			$data['status']     = 0;
			$data['names']      = json_encode(array_values($cart['name']), JSON_UNESCAPED_UNICODE);
			$data['quantities'] = json_encode(array_values($cart['quantity']));
			$data['pictures']   = json_encode(array_values($cart['picture']));
			$data['date']       = date(DB_DATETIME_FORMAT);
			//$data['check_out']  = json_encode($cart['check_out'], JSON_UNESCAPED_UNICODE);
			$cart['idCart']     = $data['id'];

			Session::set('cart', $cart);


			$user    = $params['form_user'];
			$name    = $user['name'];
			$email   = $user['email'];
			$phone   = $user['phone'];
			$address = $user['address'];

			$query  = "UPDATE `user` SET `fullname`='$name', `telephone`= '$phone', `address`='$address' WHERE `email`= '$email'";

			$this->query($query);

			$this->setTable('cart');
			$this->insert($data);
			Session::delete('cart');
		}
	}

	//===== RESET PASSWORD ======
	public function changePassword($params, $options = [])
	{
		$id          = $params['form']['id'];
		$old         = md5($params['form']['old-password']);
		$newPassword = md5($params['form']['new-password']);
		$query       = "UPDATE `$this->table` SET `password` = '$newPassword' WHERE (`password` = '$old' AND `id` = '$id')";
		$this->query($query);

		$result = $this->affectedRows();

		if ($result) {
			Session::set('pass', 'Thay đổi mật khẩu thành công !');
		} else {
			Session::set('pass', 'Mật khẩu cũ không chính xác. Xin kiểm tra lại !');
		}
	}
}
