<?php
class NewsController extends Controller
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

	
	public function indexAction()
	{
		$this->_view->_title = 'Tin tức';
		$this->_view->category       = $this->_model->listItem($this->_arrParam, ['task' => 'category']);
		$this->_view->specialMoto1   = $this->_model->listItem($this->_arrParam, ['task' => 'specialMoto1']);
		$this->_view->specialMoto2   = $this->_model->listItem($this->_arrParam, ['task' => 'specialMoto2']);

		$this->_view->news           = $this->_model->listItem($this->_arrParam, ['task' => 'news']);
		$this->_view->render('news/index');
	}

	public function detailAction()
	{
		$this->_view->category       = $this->_model->listItem($this->_arrParam, ['task' => 'category']);
		$this->_view->specialMoto1   = $this->_model->listItem($this->_arrParam, ['task' => 'specialMoto1']);
		$this->_view->specialMoto2   = $this->_model->listItem($this->_arrParam, ['task' => 'specialMoto2']);


		$this->_view->_title 		= 'Info News';
		// $ids = $this->_model->getIDMoto($this->_arrParam);
		if (isset($this->_arrParam['news_id']) /* && $ids == true */) {
			
			 $this->_view->OneNews   = $this->_model->listItem($this->_arrParam, ['task' => 'OneNews']);
			$this->_view->render($this->_arrParam['controller'] . '/detail');
		} else {
			URL::redirect('frontend', 'index', 'index');
		}
	}
}
