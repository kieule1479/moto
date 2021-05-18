<?php

//===== VARIABLE ======
$moduleName     = $this->arrParam['module'];
$controllerName = $this->arrParam['controller'];
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
$inputName = Helper::input('text', 'form[name]', 'form[name]', $dataForm['name'], 'form-control form-control-sm');
$rowName   = Helper::row('Name', $inputName, true);


//===== ROW STATUS ======
$selectStatus = Helper::select('form[status]', 'custom-select custom-select-sm', ['default' => '- Select Status -', 1 => 'Active', 0 => 'Inactive'], $dataForm['status']);
$rowStatus    = Helper::row('Status', $selectStatus, true);

//===== ROW DESCRIPTION ======
$rowVideo   = Helper::rowTextarea('form[video]', 'col-sm-2 col-form-label text-sm-right', 'Video', 'editor', 'form[video]', '10', $dataForm['video']);

//===== ROW PICTURE ======
$inputPicture = Helper::inputPicture('picture', 'file');
$rowPicture   = Helper::row('Picture', $inputPicture);

//===== INPUT PICTURE HIDDEN ======
$inputPictureHidden = Helper::input('hidden', 'picture', 'picture', '');


//===== INPUT TOKEN ======
$inputToken   = Helper::input('hidden', 'form[token]', 'token', time());

//===== IMG ======
$nameImg = $dataForm['picture'];
$gallery = json_decode($dataForm['gallery']);

$img     = '';
$arrImg     = '';

if (isset($this->arrParam['id'])) {
    $img = ' <img style=" width:200px; margin-left: 165px;" src="' . URL_PUBLIC . 'files/video/' . $nameImg . '" alt="your image" />';
}

//===== STR ROW ======
$strRow = $rowName. $rowVideo . $rowStatus  . $rowPicture . $img . $inputPictureHidden . $inputToken;

//===== STR BTN ======
$strBtn = $buttonSave . $buttonSaveClose . $buttonSaveNew . $buttonCancel;



//!=================================================== END PHP =======================================================
?>

<section class="content">
    <div class="container-fluid">

        <?= $this->errors ?? '' ?>
        <div class="card card-info card-outline">
            <div class="card-body">
                <form action="" method="post" class="mb-0" id="admin-form" enctype="multipart/form-data">
                    <?= $strRow;   ?>
                    <script>
                        var editor1 = CKEDITOR.replace('form[video]', {
                            customConfig: 'config06.js'
                        });
                       

                        CKFinder.setupCKEditor(editor, "moto/libs/plugins/ckfinder/");
                    </script>
                </form>
            </div>
            <div class="card-footer">
                <div class="col-12 col-sm-8 offset-sm-2">
                    <?= $strBtn ?>
                </div>
            </div>

        </div>
    </div>
</section>