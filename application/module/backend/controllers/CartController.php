<?php
class CartController extends Controller
{
	//===== CONSTRUCT ======
	public function __construct($arrParams)
	{
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('admin/theme_admin/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}

	//===== INDEX (LIST) ======
	public function indexAction()
	{

		$this->_view->_title = ucfirst($this->_controller) . ' Manager :: List';

		 $totalItems       = $this->_model->countItems($this->_arrParam);
		 $configPagination = ['totalItemsPerPage' => 3, 'pageRange' => 3];
		$this->setPagination($configPagination);
		$this->_view->pagination    = new Pagination($totalItems, $this->_pagination);
	
		$this->_view->Items    = $this->_model->listItem($this->_arrParam, null);
		$this->_view->slbGroup = $this->_model->itemInSelectBox($this->_arrParam);
		$this->_view->render($this->_controller . '/index');
	}

	
	//===== AJAX CHANGE GROUP  ======
	public function ajaxChangeStatusAction()
	{

		$result = $this->_model->ajaxChangeStatus($this->_arrParam);
		echo json_encode($result);
	}

	//===== DELETE ACTION ======
	public function deleteAction()
	{
		$this->_model->deleteItems($this->_arrParam);
		URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
	}

}
