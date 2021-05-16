<?php
class MotoController extends Controller{
	
	//===== __CONSTRUCT ======
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('default/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}
	
	//===== LIST ======
	public function indexAction()
	{
		$this->_view->_title 		= 'Moto';

		$totalItems          = $this->_model->countItems($this->_arrParam);
        $configPagination    = ['totalItemsPerPage'    => 8, 'pageRange' => 3];
        $this->setPagination($configPagination);
        $this->_view->pagination    = new Pagination($totalItems, $this->_pagination);

		
		$this->_view->allMoto        = $this->_model->listItem($this->_arrParam,['task'=>null]);
		$this->_view->categoryList   = $this->_model->listItem($this->_arrParam,['task'=>'categoryList']);
		$this->_view->motoInCategory = $this->_model->listItem($this->_arrParam,['task'=>'motoInCategory']);
		$this->_view->specialMoto1   = $this->_model->listItem($this->_arrParam,['task'=>'specialMoto1']);
		$this->_view->specialMoto2   = $this->_model->listItem($this->_arrParam,['task'=>'specialMoto2']);
		
		$this->_view->render($this->_arrParam['controller'] . '/index');
	}

	
	// ACTION: DETAIL moto
	public function detailAction(){
		$this->_view->_title 		= 'Info Moto';
		$ids = $this->_model->getIDMoto($this->_arrParam);
		if (isset($this->_arrParam['moto_id']) && $ids == true){
			$this->_view->relateMoto   = $this->_model->listItem($this->_arrParam,['task'=>'relateMoto']);
			$this->_view->infoMoto     = $this->_model->infoItem($this->_arrParam);
			$this->_view->specialMoto2 = $this->_model->listItem($this->_arrParam,['task'=>'specialMoto2']);
			$this->_view->specialMoto1 = $this->_model->listItem($this->_arrParam,['task'=>'specialMoto1']);
			$this->_view->newMoto1     = $this->_model->listItem($this->_arrParam,['task'=>'newMoto1']);
			$this->_view->newMoto2     = $this->_model->listItem($this->_arrParam,['task'=>'newMoto2']);			
			$this->_view->render($this->_arrParam['controller'] . '/detail');			
	   }else{
		   URL::redirect('frontend','index','index');
	   }
	}

	

}