<?php

//===== VARIABLE ======
$moduleName     = $this->arrParam['module'];
$controllerName = $this->arrParam['controller'];
$actionName     = $this->arrParam['action'];
$action         = isset($this->arrParam['id']) ? "form&id={$this->arrParam['id']}" : "form";
$dataForm       = $this->arrParam['form'];

//===== BUTTON SAVE ======
$linkSave   = URL::createLink($moduleName, $controllerName, $action, ['type' => 'save']);
$buttonSave = Helper::button($linkSave, 'btn btn-sm btn-success mr-1', 'Save');

//===== BUTTON SAVE CLOSE ======
$linkSaveClose   = URL::createLink($moduleName, $controllerName, $action, ['type' => 'save-close']);
$buttonSaveClose = Helper::button($linkSaveClose, 'btn btn-sm btn-success mr-1', 'Save & Close');

//===== BUTTON SAVE NEW ======
$linkSaveNew   = URL::createLink($moduleName, $controllerName, $action, ['type' => 'save-new']);
$buttonSaveNew = Helper::button($linkSaveNew, 'btn btn-sm btn-success mr-1', 'Save & New');

//===== BUTTON CANCEL ======
$linkCancel   = URL::createLink($moduleName, $controllerName, 'index');
$buttonCancel = Helper::button($linkCancel, 'btn btn-sm btn-danger mr-1', 'Cancel');

//===== ROW NAME ======
$inputName = Helper::input('text', 'form[name]', 'name', $dataForm['name'], 'form-control form-control-sm');
$rowName   = Helper::row('Name', $inputName, true);

//===== ROW ORDERING ======
$inputOrdering = Helper::input('number', 'form[ordering]', 'ordering', $dataForm['ordering'], 'form-control form-control-sm', 'min="1"');
$rowOrdering   = Helper::row('Ordering', $inputOrdering, true);

//===== ROW STATUS ======
$selectStatus = Helper::select('form[status]', 'custom-select custom-select-sm', ['default' => '- Select Status -', '1' => 'Active', '0' => 'Inactive'], $dataForm['status']);
$rowStatus    = Helper::row('Status', $selectStatus, true);

//===== ROW PICTURE ======
$inputPicture = Helper::inputPicture('picture', 'file');
$rowPicture   = Helper::row('Picture', $inputPicture);

//===== INPUT PICTURE HIDDEN ======
$inputPictureHidden = Helper::input('hidden', 'picture', 'picture', '');

//===== INPUT TOKEN ======
$inputToken     = Helper::input('hidden', 'form[token]', 'token', time());

//===== IMG ======
$nameImg = $dataForm['picture'];
$img = '';
if (isset($dataForm['id'])) {
    $img = ' <img style=" width:200px; margin-left: 165px;" src="' . URL_PUBLIC . 'files/category/220x147-' . $nameImg . '" alt="your image" />';
}

//===== ROW ID ======
$inputID        = '';
$rowID          = '';
if (isset($this->arrParam['id'])) {
    $inputID    = Helper::input('text', 'form[id]', 'id', $dataForm['id'], 'form-control form-control-sm', 'readonly');
    $rowID      = Helper::row('ID', $inputID);
}

//===== STR ROW ======
$strRow = $rowID . $rowName . $rowOrdering . $rowStatus . $rowPicture . $inputPictureHidden . $img . $inputToken;

//===== STR BTN ======
$strBtn = $buttonSave . $buttonSaveClose . $buttonSaveNew . $buttonCancel;




//!=================================================== END PHP =======================================================
?>

<?= $this->errors ?? '' ?>
<div class="card card-info card-outline">
    <div class="card-body">
        <form action="" method="post" class="mb-0" id="admin-form" enctype="multipart/form-data">
            <?= $strRow ?>
        </form>
        <div class="col-12 col-sm-8 offset-sm-2">
            <img src="" alt="preview image" id="admin-preview-image" style="display: none;width: 200px; max-width: 400px">
        </div>
    </div>
    <div class="card-footer">
        <div class="col-12 col-sm-8 offset-sm-2">
            <?= $strBtn ?>
        </div>
    </div>
</div>