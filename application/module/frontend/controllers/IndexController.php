<?php
class IndexController extends Controller
{

	//===== __CONSTRUCT ======
	public function __construct($arrParams)
	{
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('default/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}

	//===== INDEX ======
	public function indexAction()
	{
		$this->_view->_title              = 'Trang chủ';
		$this->_view->sliders             = $this->_model->listItem($this->_arrParam, ['task'=>'sliders']);
		$this->_view->hotProducts         = $this->_model->listItem($this->_arrParam, ['task' => 'hotProducts']);
		$this->_view->hotCategoryTitles   = $this->_model->listItem($this->_arrParam, ['task' => 'hotCategoryTitles']);
		$this->_view->specialCategoryList = $this->_model->listItem($this->_arrParam, ['task' => 'specialCategoryList']);
		$this->_view->categoryInMotos     = $this->_model->listItem($this->_arrParam, ['task' => 'categoryInMotos']);
		$this->_view->newMotoInfos        = $this->_model->listItem($this->_arrParam, ['task' => 'newMotoInfos']);
			
		$this->_view->render($this->_arrParam['controller'] . '/index');
	}


	//===== AJAX QUICK VIEW ACTION ======
	public function ajaxQuickViewAction()
	{
		$result = $this->_model->infoItem($this->_arrParam, ['task' => 'quick-view']);
		echo json_encode($result);
	}

	//===== NOTICE ======
	public function noticeAction(){
		$this->_view->_title          = 'Thông báo';
		$this->_view->render($this->_arrParam['controller'] . '/notice');

	}

	//===== LOGOUT ======
	public function logoutAction(){
		Session::delete('user');
		URL::redirect('frontend', 'index', 'index');
	}


}
