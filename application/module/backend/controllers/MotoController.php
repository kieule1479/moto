<?php
class MotoController extends Controller
{

     //===== CONSTRUCT ======
     public function __construct($arrParams)
     {
         parent::__construct($arrParams);
         $this->_templateObj->setFolderTemplate('admin/theme_admin/');
         $this->_templateObj->setFileTemplate('index.php');
         $this->_templateObj->setFileConfig('template.ini');
         $this->_templateObj->load();
        //  $this->_moduleName = $this->_arrParam['module'];
        //  $this->_controllerName = $this->_arrParam['controller'];
     }
     
    //===== INDEX ACTION ======
    public function indexAction()
    {
        $this->_view->_title = ucfirst($this->_controller) . ' Manager :: List';

        $totalItems       = $this->_model->countItems($this->_arrParam);
        $configPagination = ['totalItemsPerPage'    => 20, 'pageRange' => 3];
        $this->setPagination($configPagination);
        
        $this->_view->pagination            = new Pagination($totalItems, $this->_pagination);
        $this->_view->countActive           = $this->_model->countItems($this->_arrParam, ['task' => 'count-active']);
        $this->_view->countInactive         = $this->_model->countItems($this->_arrParam, ['task' => 'count-inactive']);
        $this->_view->slbFilterCategory     = $this->_model->itemInSelectBox($this->_arrParam, 'add-default');
        $this->_view->slbFilterCategoryList = $this->_model->itemInSelectBox($this->_arrParam);
        $this->_view->items                 = $this->_model->listItems($this->_arrParam);
        $this->_view->render("{$this->_controller}/index");
        
    }

    //===== FORM ACTION ======
    public function formAction()
    {
        $this->_view->_title = ucfirst($this->_controller) . ' Manager :: Add';
      
        if (!empty($_FILES)) {
            $this->_arrParam['form']['picture'] = $_FILES['picture'];
            $this->_arrParam['form']['gallery'] = $_FILES['gallery'];
            $this->_validate->addSourceElement('picture',  $_FILES['picture']);
            $this->_validate->addSourceElement('gallery',  $_FILES['gallery']);
        }
        if (isset($this->_arrParam['id']) && !isset($this->_arrParam['form']['token'])) { // EDIT
           
            $this->_view->_title = ucfirst($this->_controller) . ' Manager :: Edit';
            $this->_arrParam['form'] = $this->_model->infoItem($this->_arrParam);
            if (empty($this->_arrParam['form'])) URL::redirect($this->_module, $this->_controller, 'index');
        }

        if (isset($this->_arrParam['form']['token'])) {// ADD

           

            $this->_validate->validate($this->_model);
            $this->_arrParam['form'] = $this->_validate->getResult();
           
            if (!$this->_validate->isValid()) {
                $this->_view->errors = $this->_validate->showErrorsAdmin();
            } else {
               
                $task = isset($this->_arrParam['id']) ? 'edit' : 'add';
                $id = $this->_model->saveItem($this->_arrParam, ['task' => $task]);
                
                $this->redirectAfterSave(['id' => $id]);
            }
        }
        $this->_view->arrParam = $this->_arrParam;
        $this->_view->slbCategory = $this->_model->itemInSelectBox($this->_arrParam, 'add-default');
        $this->_view->render("{$this->_controller}/form");
    }

    //===== AJAX CHANGE CATEGORY ACTION ======
    public function ajaxChangeCategoryAction()
    {
        $result = $this->_model->changeCategory($this->_arrParam);
        echo json_encode($result);
    }

    //===== AJAX CHANGE SPECIAL ACTION ======
    public function ajaxSpecialAction()
    {
        
        $result = $this->_model->changeStatus($this->_arrParam, ['task' => 'ajax_special']);
        echo json_encode($result);
    }

    //===== AJAX CHANGE STATUS ACTION ======
    public function ajaxStatusAction()
    {
        $result = $this->_model->changeStatus($this->_arrParam, ['task' => 'ajax_status']);
        echo json_encode($result);
    }

    //===== RESET PASSWORD ACTION ======
    public function resetPasswordAction()
    {
        $this->_view->_title = ucfirst($this->_controller) . ' Manager :: Reset Password';
        if (isset($this->_arrParam['new-password'])) {
            $this->_model->resetPassword($this->_arrParam);
            URL::redirect($this->_arrParam['module'], $this->_controller, 'index');
        }
        $this->_view->item = $this->_model->infoItem($this->_arrParam);
        $this->_view->render("{$this->_controller}/reset-password");
    }

     //===== CHANGE STATUS ACTIVE ======
     public function changeStatusAction()
     {
         $this->_model->changeStatus($this->_arrParam);
         URL::redirect($this->_module, $this->_controller, 'index');
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
