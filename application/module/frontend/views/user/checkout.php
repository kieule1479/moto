<?php

if ($this->hienthi == true) {


    $dataForm = $this->user;


    // ROW NAME
    $inputName  = Helper::input('text', 'form_user[name]', 'form[name]', $dataForm['fullname'], 'form-control form-control-sm');
    $rowName    = Helper::row('Họ tên', $inputName, true);

    //ROW PHONE
    $inputPhone  = Helper::input('number', 'form_user[phone]', 'form[phone]', $dataForm['telephone'], 'form-control form-control-sm');
    $rowPhone    = Helper::row('Điện thoại', $inputPhone, true);

    // ROW  EMAIL
    $inputEmail  = Helper::input('text', 'form_user[email]', 'form[email]', $dataForm['email'], 'form-control form-control-sm', 'readonly');
    $rowEmail    = Helper::row('Email', $inputEmail, true);

    //ROW FULL NAME
    $inputAddress  = Helper::input('text', 'form_user[address]', 'form[address]', $dataForm['address'], 'form-control form-control-sm');
    $rowAddress    = Helper::row('Địa chỉ', $inputAddress);

    //INPUT TOKEN
    $inputToken = Helper::input('hidden', 'form[token]', 'form[token]', time(), null);

    $action = isset($this->arrParam['id']) ? 'form&id=' . $this->arrParam['id'] : 'form';

    // SAVE
    $linkSave = URL::createLink('fontend', 'user', 'buy');
    $btnSave  = Helper::button($linkSave, 'btn btn-sm btn-success mr-1', 'Đặt hàng');


    //$btnSave        = Helper::createActionButton("javascript:submitForm('$linkSave')", 'btn-success mr-1', 'Đặt hàng');

    //===== BUTTON SAVE ======



    // Save & New
    $linkNotice = URL::createLink('frontend', 'index', 'notice');
    $linkCancel = URL::createLink($this->arrParam['module'], $this->arrParam['controller'], 'index');
    $btnSave    = Helper::button($linkCancel, 'btn btn-sm btn-danger mr-1', 'Cancel');
    // $btnCancel      = Helper::createActionButton($linkCancel, 'btn-danger mr-1', 'Cancel');

    $inputIDHidden = '';
    if (isset($this->arrParam['id'])) {
        $inputIDHidden = Helper::input('hidden', 'form[id]', 'form[id]', $this->arrParam['id'], NULL);
    }

    foreach ($this->motoInCart as $key => $value) {
        $linkDetail = URL::createLink('frontend', 'moto', 'detail', ['moto_id' => $value['id']]);
        $picture    = URL_UPLOAD . 'moto' . DS . $value['picture'];
        $name       = $value['name'];
        $quantity   = $value['quantity'];
        $id         = $value['id'];
        $price      = $value['price'];
        $newPrice   = ($price - ($price * $data['sale_off'] / 100));
        $totalPrice = $value['totalprice'];
        $total      = $total + $value['totalprice'];

        $xhtml .= '
            <input type="hidden" name="form[moto_id][]" value="' . $id . '" id="input_moto_id_' . $id . '">
            <input type="hidden" name="form[price][]" value="' . $price . '" id="input_price_' . $id . '">
            <input type="hidden" name="form[quantity][]" value="' . $quantity . '" id="input_quantity_' . $id . '">
            <input type="hidden" name="form[name][]" value="' . $name . '" id="input_name_' . $id . '">
            <input type="hidden" name="form[picture][]" value="' . $value['picture'] . '" id="input_picture_' . $id . '">
    ';
    }

    $btnXacNhan = '<div class="col-6"><button type="submit" style="margin-left: 400px" class="btn btn-solid">Xác nhận</button></div>';

    $xhtmlInput =   $rowEmail . $rowName . $rowPhone .  $rowAddress . $inputToken . $inputIDHidden . $xhtml . $btnXacNhan;
}


//!=================================================== END PHP =======================================================
?>
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2 class="py-2">Thông tin đặt hàng</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
//gui mail

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


if ($this->hienthi == false) {


    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';

    // echo '<h3 style="color:red;font-weight:bold">' . count($_POST['form']['moto_id']) . '</h3>';

    $count = count($_POST['form']['moto_id']);


    for ($i = 0; $i < $count; $i++) {
        $token    = $_POST['form']['token'];
        // $moto_id  = $_POST['form']['moto_id'][$i];
        $price    = $_POST['form']['price'][$i];
        $quantity = $_POST['form']['quantity'][$i];
        $name     = $_POST['form']['name'][$i];
        $picture  = $_POST['form']['picture'][$i];
        $total = $quantity * $price;

        $xhtml .= '
                 <tr>            
                    <td width="2%" class="text-center">' . $token . '</td>
                    <td width="2%" class="text-center ">' . $name . '</td>       
                    <td width="2%"  class="text-center">' . number_format($quantity) .  ' x ' . number_format($price) . '</td>
                    <td width="2%"  class="text-center">' . number_format($total) . ' đ</td>
                </tr>
              ';
    }

    require PATH_LIBRARY . 'PHPMailer/src/Exception.php';
    require PATH_LIBRARY . 'PHPMailer/src/PHPMailer.php';
    require PATH_LIBRARY . 'PHPMailer/src/OAuth.php';
    require PATH_LIBRARY . 'PHPMailer/src/POP3.php';
    require PATH_LIBRARY . 'PHPMailer/src/SMTP.php';

    require 'vendor/autoload.php';
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->CharSet = 'UTF-8';

        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        //gia lap trinh duyệt và 1 trang gmail



        $mail->Username   = 'kieule1579@gmail.com';                     //SMTP username
        $mail->Password   = 'lslkldkdsS23@#%$^*G';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('kieule1579@gmail.com', 'Kieu le');
        $mail->addAddress($_POST['form_user']['email'], $_POST['form_user']['name']);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Chào bạn đây là thông tin mua hàng của moto VN';

        $content = '<table class="table table-bordered table-hover text-nowrap btn-table mb-0">
                        <thead>
                            <tr>      </tr>
                            <tr>
                                <th  class="text-left">Mã đơn hàng</th>
                                <th  class="text-left">Thông tin</th> 
                                <th  class="text-left">Chi tiết</th>
                                <th  class="text-left">Tổng tiền</th>
                            </tr>
                        </thead>
                        <tbody>';
        $content .= $xhtml;

        $content .=     '</tbody>
                    </table>';

        $mail->Body    =  $content;
        $mail->send();
        // echo 'Đã gửi đơn hàng thành công !';
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }

    $thongBaoMuaHangThanhCong = '<section class="p-0">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="error-section1">
                                                <h2>Bạn đã đặt hàng thành công !!!</h2> 
                                                <h3>Kiểm tra lại email xác nhận. Xin cảm ơn !</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                                 ';

    $btnTiepTucMuaSam = '<div class="col-6"><button type="" style="margin-left: 400px" class="btn btn-solid"><a href="index.php?module=frontend&controller=index&action=index">Tiếp tục mua sắm</a></button></div>';
}

?>


<div class="card card-info card-outline">
    <div class="row">
        <div class="col-12">
            <div class="container">
                <div class="kk001">

                    <?php echo $this->errors; ?>
                </div>
                <?php echo $thongBaoMuaHangThanhCong ?>

                <div class="card-body">

                    <form action="" method="post" id="admin-form">
                        <?php echo $xhtmlInput ?>
                        <?php echo $XacNhan ?>
                        <?php echo $btnTiepTucMuaSam ?>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <div class="card-footer">
        <div class="col-12 col-sm-8 offset-sm-2">

        </div>

    </div>
</div>