<?php

$moduleName     = $this->arrParam['module'];
$controllerName = $this->arrParam['controller'];
$dataForm       = $this->arrParam['form'];

//===== ROW FULLNAME ======
$inputFullName = Helper::input('text', 'form[fullname]', 'form[fullname]', $dataForm['fullname'], 'form-control form-control-sm');
$rowFullName   = Helper::row('FullName', $inputFullName);

//===== ROW EMAIL ======
$inputEmail = Helper::input('text', 'form[email]', 'form[email]', $dataForm['email'], 'form-control form-control-sm');
$rowEmail   = Helper::row('Email', $inputEmail, true);

//===== ROW ID ======
$inputID = Helper::input('text', 'form[id]', 'form[id]', $dataForm['id'], 'form-control form-control-sm', 'readonly');
$rowID   = Helper::row('ID', $inputID, true);


$inputToken = Helper::input('hidden', 'form[token]', 'token', time());

//===== BUTTON SAVE ======
$linkSave   = URL::createLink($moduleName, $controllerName, $actionName, ['type' => 'save']);
$buttonSave = Helper::button($linkSave, 'btn btn-sm btn-success mr-1', 'Save');

//===== BUTTON SAVE CLOSE ======
$linkSaveClose   = URL::createLink($moduleName, $controllerName, $actionName, ['type' => 'save-close']);
$buttonSaveClose = Helper::button($linkSaveClose, 'btn btn-sm btn-success mr-1', 'Save & Close');

//===== BUTTON CANCEL ======
$linkCancel   = URL::createLink($moduleName, $controllerName, 'index');
$buttonCancel = Helper::button($linkCancel, 'btn btn-sm btn-danger mr-1', 'Cancel');


//===== STR BUTTON ======
$strButton = $buttonSave . $buttonSaveClose  . $buttonCancel;
$strRow    = $rowFullName . $rowEmail . $rowID . $inputToken;


//!=================================================== END PHP ===================================================
?>

<section class="content">
    <div class="container-fluid">
        <?= $this->errors ?? '' ?>
        <div class="card card-info card-outline">
            <div class="card-body">
                <form action="" method="post" class="mb-0" id="admin-form">
                    <?= $strRow ?>
                </form>
            </div>
            <div class="card-footer">
                <div class="col-12 col-sm-8 offset-sm-2">
                    <?= $strButton ?>
                </div>
            </div>
        </div>
</section>