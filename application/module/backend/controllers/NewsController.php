<?php
class NewsController extends Controller
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
    //===== INDEX ACTION ======
    public function indexAction()
    {
        $this->_view->_title = ucfirst($this->_controller) . ' Manager :: List';

        $totalItems          = $this->_model->countItems($this->_arrParam);
        $configPagination    = ['totalItemsPerPage'    => 3, 'pageRange' => 3];
        $this->setPagination($configPagination);
        $this->_view->pagination    = new Pagination($totalItems, $this->_pagination);

        $this->_view->countActive   = $this->_model->countItems($this->_arrParam, ['task' => 'count-active']);
        $this->_view->countInactive = $this->_model->countItems($this->_arrParam, ['task' => 'count-inactive']);
        $this->_view->items         = $this->_model->listItems($this->_arrParam);
        
        $this->_view->render($this->_controller . '/index');
    }

    //===== FORM ACTION ======
    public function formAction()
    {
        

       
        if (!empty($_FILES)) {
            
            $this->_arrParam['form']['picture'] = $_FILES['picture'];
            $this->_validate->addSourceElement('picture',  $_FILES['picture']);
        }
        $this->_view->_title = ucfirst($this->_controller) . ' Manager :: Add';
        if (isset($this->_arrParam['id']) && !isset($this->_arrParam['form']['token'])) {
            $this->_view->_title = ucfirst($this->_controller) . ' Manager :: Edit';
           
            $this->_arrParam['form'] = $this->_model->infoItem($this->_arrParam);
            if (empty($this->_arrParam['form'])) URL::redirect($this->_module, $this->_controller, 'index');
        }
        if (isset($this->_arrParam['form']['token'])) {

            $this->_validate->validate($this->_model);
            $this->_arrParam['form'] = $this->_validate->getResult();
            if (!$this->_validate->isValid()) {
                $this->_view->errors = $this->_validate->showErrorsAdmin();
            } else {
             
                 $task = isset($this->_arrParam['id']) ? 'edit' : 'add';
               
                $id   = $this->_model->saveItem($this->_arrParam, ['task' => $task]);
                
                $this->redirectAfterSave(['id' => $id]);
            }
        }
        $this->_view->arrParam = $this->_arrParam;
        $this->_view->render("{$this->_controller}/form");
    }

    //===== AJAX STATUS ACTION ======
    public function ajaxStatusAction()
    {
        $result = $this->_model->changeStatus($this->_arrParam, ['task' => 'ajax_status']);
        echo json_encode($result);
    }

    //===== AJAX ORDERING ACTION ======
    public function ajaxOrderingAction()
    {
        $result = $this->_model->ajaxOrdering($this->_arrParam);
        echo json_encode($result);
    }

    //===== ACTIVE ACTION  ======
    public function activeAction()
    {
        $this->_model->changeStatus($this->_arrParam, ['task' => 'active']);
        URL::redirect($this->_module, $this->_controller, 'index');
    }

    //===== INACTIVE ACTION  ======
    public function inactiveAction()
    {
        $this->_model->changeStatus($this->_arrParam, ['task' => 'inactive']);
        URL::redirect($this->_module, $this->_controller, 'index');
    }

    //===== DELETE ACTION ======
    public function deleteAction()
    {
        $this->_model->deleteItems($this->_arrParam);
        URL::redirect($this->_module, $this->_controller, 'index');
    }
}
