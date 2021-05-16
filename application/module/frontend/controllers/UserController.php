<?php
class UserController extends Controller
{

	//===== CONSTRUCT ======
	public function __construct($arrParams)
	{
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('default/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}

	//===== ĐĂNG KÍ ======
	public function registerAction()
	{
		$this->_view->_title = 'Đăng ký';
		$userInfo    = Session::get('user');
		if ($logged = ($userInfo['login'] == true && $userInfo['time'] + TIME_LOGIN >= time())) {
			URL::redirect('frontend', 'index', 'index');
		};

		if (isset($this->_arrParam['form'])) {
			URL::checkRefreshPage($this->_arrParam['form']['token'], 'frontend', 'user', 'register');
			if (isset($this->_arrParam['form']['token'])) {
				$this->_validate->validate($this->_model);
				$this->_arrParam['form'] = $this->_validate->getResult();
				if (!$this->_validate->isValid()) {
					$this->_view->errors = $this->_validate->showErrorsPublic();
				} else {
					$id = $this->_model->saveItem($this->_arrParam, ['task' => 'user_register']);
					URL::redirect('frontend', 'index', 'notice', ['type' => 'register-success']);
				}
			}
			$this->_view->arrParam = $this->_arrParam;
		}

		$this->_view->render('user/register');
	}

	//===== ĐĂNG NHẬP  ======
	public function loginAction()
	{

		$this->_view->_title = 'Đăng nhập';
		$userInfo    = Session::get('user');
		if ($logged = ($userInfo['login'] == true && $userInfo['time'] + TIME_LOGIN >= time())) {

			URL::redirect('frontend', 'index', 'index');
		}

		if ($this->_arrParam['form']['token'] > 0) {

			$this->_validate->validateFrontend($this->_model);
			$this->_arrParam['form'] = $this->_validate->getResult();

			if (!$this->_validate->isValid()) {
				$this->_view->errors = $this->_validate->showErrorsPublic();
			} else {

				$infoUser = $this->_model->infoItem($this->_arrParam);
				$arrSessions = ['login' => true, 'info' => $infoUser, 'time' => time(), 'group_acp' => $infoUser['group_id'],];
				Session::set('user', $arrSessions);
				URL::redirect('frontend', 'index', 'index');
			}
		}


		$this->_view->render('user/login');
	}

	//===== ORDER ACTION ======
	public function orderAction()
	{




		//Session::delete('cart');

		$cart   = Session::get('cart');
		$motoID = $this->_arrParam['moto_id'];
		$price  = $this->_arrParam['price'];
		// $data = $this->_model->infoItem($this->_arrParam);
		// $quantity = $this->_arrParam['quantity'];
		// //$name = $this->_arrParam['name'	];
		if (empty($cart)) {
			$cart['quantity'][$motoID] = 1; // so luong
			$cart['price'][$motoID]    = $price; //gia tien
			// $cart['name'][$motoID]     = $data['name'];
			// $cart['picture'][$motoID]  = $data['picture'];
			// $cart['id'][$motoID]       = $data['id'];	
		} else {
			if (key_exists($motoID, $cart['quantity'])) { // da ton tai sach can mua
				$cart['quantity'][$motoID] += 1;
				$cart['price'][$motoID]     = $price * $cart['quantity'][$motoID];
				// $cart['name'][$motoID]      = $data['name'];
				// $cart['picture'][$motoID]   = $data['picture'];
				// $cart['id'][$motoID]        = $data['id'];
			} else { // chua ton tai sach can mua
				$cart['quantity'][$motoID] = 1;
				$cart['price'][$motoID]    = $price;
				// $cart['name'][$motoID]     = $data['name'];
				// $cart['picture'][$motoID]  = $data['picture'];
				// $cart['id'][$motoID]       = $data['id'];
			}
		}


		Session::set('cart', $cart);
		URL::redirect('frontend', 'moto', 'detail', ['moto_id' => $motoID]);
	}

	//===== AJAX CART ACTION ======
	public function ajaxCartAction()
	{

		$result = $this->_model->ajaxCart($this->_arrParam);
		echo json_encode($result);
	}

	//===== CART ACTION ======
	public function cartAction()
	{
		$this->_view->_title = 'Giỏ hàng';
		$this->_view->motoInCart = $this->_model->listItem($this->_arrParam, ['task' => 'motos_in_cart']);
		$this->_view->render($this->_arrParam['controller'] . '/cart');
	}

	//===== CHECK OUT ACTION ======
	public function checkoutAction()
	{

		$this->_view->hienthi = false;
		$this->_view->_title     = 'Thông tin đặt hàng';
		$this->_view->motoInCart = $this->_model->listItem($this->_arrParam, ['task' => 'motos_in_cart']);
		// $this->_view->user       = $this->_model->infoItem($this->_arrParam, ['task' => 'info_user']);

		if (isset($this->_arrParam['form']['token'])) {		 //khi nhan nut xac nhan	
			$this->_validate->validateInfoOrder($this->_arrParam['form_user']);
			$this->_arrParam['form_user'] = $this->_validate->getResult();
			if (!$this->_validate->isValid()) {
				$this->_view->user    = $this->_model->infoItem($this->_arrParam, ['task' => 'info_user']);
				$this->_view->hienthi = true;
				$this->_view->errors = $this->_validate->showErrorsPublic();
			} else {// khong co loi

				$this->_model->save($this->_arrParam, ['task' => 'submit_cart']);
				// URL::redirect('frontend', 'index', 'notice', ['type' => 'dat_hang_thanh_cong']);
			}
		} else { // moi vao trang
			$this->_view->hienthi = true;
			$this->_view->user    = $this->_model->infoItem($this->_arrParam, ['task' => 'info_user']);
		}
		$this->_view->render($this->_arrParam['controller'] . '/checkout');
	}


	//=====  ACTION ======
	public function historyAction()
	{

		$this->_view->_title = 'Lịch sử';
		$this->_view->items = $this->_model->listItem($this->_arrParam, ['task' => 'history_cart']);
		$this->_view->render($this->_arrParam['controller'] . '/history');
	}
	//=====  ACTION ======
	public function accountAction()
	{

		$this->_view->_title = 'Thông tin người dùng';
		// $this->_view->items = $this->_model->listItem($this->_arrParam, ['task' => 'account']);
		$this->_view->itemsUser = $this->_model->infoItem($this->_arrParam, ['task' => 'info_user']);

		if ($this->_arrParam['form']['token'] > 0) {

			$this->_validate->validateInfoUser($this->_arrParam);
			$this->_arrParam['form'] = $this->_validate->getResult();

			if (!$this->_validate->isValid()) {
				$this->_view->errors = $this->_validate->showErrorsPublic();
			} else {
				$this->_model->changeUser($this->_arrParam);
				Session::set('success', 1);
				URL::redirect($this->_module, $this->_controller, 'account');
			}
		}
		$this->_view->render($this->_arrParam['controller'] . '/account');
	}

	//===== RESET PASSWORD ACTION ======
	public function changePasswordAction()
	{
		$this->_view->_title = 'Thay đổi mật khẩu';

		if ($this->_arrParam['form']['token'] > 0) {

			$new = $this->_arrParam['form']['new-password'];
			$enter = $this->_arrParam['form']['enter-password'];

			if ($new != $enter) {
				$this->_view->error = 'Mật khẩu không khớp. Xin kiểm tra lại';
			} else {

				$this->_model->changePassword($this->_arrParam);
			}
		}
		// URL::redirect($this->_arrParam['module'], $this->_controller, 'index');



		$this->_view->render("{$this->_controller}/change_password");
	}


	//=====   AJAX DELETE ACTION ======
	public function ajaxDeleteAction()
	{

		$result = $this->_model->ajaxDelete($this->_arrParam);
		echo json_encode($result);
	}
}
