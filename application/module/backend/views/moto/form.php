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
$inputName = Helper::input('test', 'form[name]', 'form[name]', $dataForm['name'], 'form-control form-control-sm');
$rowName   = Helper::row('Name', $inputName, true);

//===== ROW SHORT DESCRIPTION ======
$rowShortDescription   = Helper::rowTextarea('form[short_description]', 'col-sm-2 col-form-label text-sm-right', 'Short Description', 'form[short_description]', 'form[short_description]', '3', $dataForm['short_description']);

//===== ROW DESCRIPTION ======
$rowDescription   = Helper::rowTextarea('form[description]', 'col-sm-2 col-form-label text-sm-right', 'Description', 'editor', 'form[description]', '10', $dataForm['description']);

//===== ROW PRICE ======
$inputPrice = Helper::input('number', 'form[price]', 'form[price]', $dataForm['price'], 'form-control form-control-sm');
$rowPrice   = Helper::row('Price', $inputPrice);

//===== ROW SALE_OFF ======
$inputSale_off = Helper::input('number', 'form[sale_off]', 'form[sale_off]', $dataForm['sale_off'], 'form-control form-control-sm');
$rowSale_off   = Helper::row('Sale Off', $inputSale_off);

//===== ROW CATEGORY ======
$category_id    = Helper::select('form[category_id]', 'custom-select custom-select-sm mr-1', $this->slbCategory, $dataForm['category_id'], '', 'data-id="' . $value['id'] . '"');
$rowCategory = Helper::row('Category', $category_id, true);

//===== ROW STATUS ======
$selectStatus = Helper::select('form[status]', 'custom-select custom-select-sm', ['default' => '- Select Status -', 1 => 'Active', 0 => 'Inactive'], $dataForm['status']);
$rowStatus    = Helper::row('Status', $selectStatus, true);

//===== ROW SPECIAL ======
$selectSpecial = Helper::select('form[special]', 'custom-select custom-select-sm', ['default' => '- Select Special -', '1' => 'Yes', '0' => 'No'], $dataForm['special']);
$rowSpecial    = Helper::row('Special', $selectSpecial, true);

//===== ROW PICTURE ======
$inputPicture = Helper::inputPicture('picture', 'file'); 
$rowPicture   = Helper::row('Picture', $inputPicture);

//===== INPUT PICTURE HIDDEN ======
$inputPictureHidden = Helper::input('hidden', 'picture', 'picture', '');

//===== ROW GALLERY ======
$inputGallery = Helper::inputPictureMultiple('gallery[]','file');
$rowGallery   = Helper::row('Gallery', $inputGallery);


//===== INPUT TOKEN ======
$inputToken   = Helper::input('hidden', 'form[token]', 'token', time());

//===== IMG ======
$nameImg = $dataForm['picture'];
$gallery = json_decode($dataForm['gallery']);

$img     = '';
$arrImg     = '';

if (isset($this->arrParam['id'])) {
    $img = ' <img style=" width:200px; margin-left: 165px;" src="' . URL_PUBLIC . 'files/moto/' . $nameImg . '" alt="your image" />';
    if(isset($gallery)){
        foreach ($gallery  as $key => $value) {
            $arrImg .= ' <img style=" width:200px; margin-left: 165px;" src="' . URL_PUBLIC . 'files/gallery/' . $value . '" alt="your image" />';
        }
    }
    
}

//===== STR ROW ======
$strRow = $rowName . $rowShortDescription . $rowDescription . $rowPrice . $rowSale_off . $rowCategory . $rowStatus . $rowSpecial . $rowPicture. $img  .$rowGallery.$arrImg. $inputPictureHidden . $inputToken;

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
                        
                        var editor1 = CKEDITOR.replace('form[description]', {
                            customConfig: 'config04.js'
                        });
                        var editor = CKEDITOR.replace('form[short_description]', {
                            customConfig: 'config03.js'
                        });
                        // CKEDITOR.replace('form[description]');

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