<?php

$dataForm  = $this->arrParam['form'];

//===== ROW NAME ======
$inputName = Helper::input('text', 'form[name]', 'form[name]', $dataForm['name'], 'form-control form-control-sm');
$rowName   = Helper::row('Name', $inputName, true);

//===== ROW STATUS ======
$sectionStatus = Helper::select('form[status]', 'custom-select custom-select-sm', ['default' => '- Select status -', 1 => 'Active', 0 => 'Inactive'], $dataForm['status']);
$rowStatus     = Helper::row('Status', $sectionStatus, true);

//===== ROW ORDERING ======
$sectionOrdering = Helper::input('number', 'form[ordering]', 'form[ordering]', $dataForm['ordering'], 'form-control form-control-sm');
$rowOrdering     = Helper::row('Ordering', $sectionOrdering, true);

//===== ROW PICTURE ======
$inputPicture = Helper::inputPicture('picture', 'file');
$rowPicture   = Helper::row('Picture', $inputPicture);

//===== INPUT PICTURE HIDDEN ======
$inputPictureHidden = Helper::input('hidden', 'picture', 'picture', '');



//===== INPUT TOKEN ======
$inputToken = Helper::input('hidden', 'form[token]', 'form[token]', time(), null);

//===== BUTTON SAVE ======
$linkSave   = URL::createLink('backend', 'slider', 'form', ['type' => 'save']);
$buttonSave = Helper::button($linkSave, 'btn btn-sm btn-success mr-1', 'Save');

//===== BUTTON SAVE CLOSE ======
$linkSaveClose   = URL::createLink('backend', 'slider', 'form', ['type' => 'save-close']);
$buttonSaveClose = Helper::button($linkSaveClose, 'btn btn-sm btn-success mr-1', 'Save & Close');

//===== BUTTON SAVE NEW ======
$linkSaveNew   = URL::createLink('backend', 'slider', 'form', ['type' => 'save-new']);
$buttonSaveNew = Helper::button($linkSaveNew, 'btn btn-sm btn-success mr-1', 'Save & New');

//===== BUTTON CANCEL ======
$linkCancel   = URL::createLink('backend', 'slider', 'index');
$buttonCancel = Helper::button($linkCancel, 'btn btn-sm btn-danger mr-1', 'Cancel');


//===== IMG ======
$nameImg = $dataForm['picture'];
$img = '';
if (isset($dataForm['id'])) {
    $img = ' <img style=" width:200px; margin-left: 165px;" src="' . URL_PUBLIC . 'files/slider/' . $nameImg . '" alt="your image" />';
}

//===== ROW ID  EDIT ======
if (isset($this->arrParam['id'])) {
    $inputID = Helper::input('text', 'form[id]', 'form[id]', $dataForm['id'], 'form-control form-control-sm ', 'readonly');
    $rowID   = Helper::row('ID', $inputID); 
}

//===== STRING BUTTON ======
$strRow = $rowID .  $rowName  . $rowStatus . $rowOrdering . $rowPicture . $img . $inputPictureHidden . $inputToken;


//===== STRING BUTTON ======
$strButton = $buttonSave . $buttonSaveClose . $buttonSaveNew . $buttonCancel;



//!=================================================== END PHP ===================================================
?>

<section class="content">
    <div class="container-fluid">
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
                    <?= $strButton ?>
                </div>
            </div>
        </div>
</section>