<?php



$module     = $_GET['module'];
$controller = $_GET['controller'];


$linkAccount        = URL::createLink($module, $controller, 'account');
$linkHistory        = URL::createLink($module, $controller, 'history');
$linkChangePassword = URL::createLink($module, $controller, 'changePassword');




if (isset($this->itemsUser)) {


    $id        = $this->itemsUser['id'];
    $email     = $this->itemsUser['email'];
    $fullname  = $this->itemsUser['fullname'];
    $telephone = $this->itemsUser['telephone'];
    $address   = $this->itemsUser['address'];
}

$action = URL::createLink($module, $controller, 'account');



//!=================================================== END PHP =======================================================
?>


<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2 class="py-2">Thông Tin Tài khoản </h2>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="faq-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="account-sidebar">
                    <a class="popup-btn">Menu</a>
                </div>
                <h3 class="d-lg-none">Tài khoản</h3>
                <div class="dashboard-left">
                    <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> Ẩn</span></div>
                    <div class="block-content">
                        <ul>
                            <li class="active"><a href=" <?php echo $linkAccount ?> ">Thông tin tài khoản</a></li>
                            <li class=""><a href="<?php echo $linkChangePassword ?> ">Thay đổi mật khẩu</a></li>
                            <li class=""><a href=" <?php echo $linkHistory ?> ">Lịch sử mua hàng</a></li>
                            <li class=""><a href=" <?php echo $linkLogOut ?> ">Đăng xuất</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="dashboard-right">
                    <?php

                    $success = '';
                    if (Session::get('success') == 1) {
                        $success = '<ul class="alert error-public alert-danger"> <li> Cập nhập thông tin thành công !</li> </ul>';
                    }
                    ?>
                    <?= $this->errors ??  $success  ?>
                    <?php 
                        Session::delete('success');
                    ?>

                    <div class=" dashboard">
                        <form action=" <?php echo $action ?> " method="post" id="admin-form" class="theme-form">

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="form[email]" value="<?= $email ?>" class="form-control" id="email" readonly="1">
                            </div>

                            <div class="form-group">
                                <label for="fullname">Họ tên</label>
                                <input type="text" name="form[fullname]" value="<?= $fullname ?>" class="form-control" id="fullname">
                            </div>

                            <div class="form-group">
                                <label for="phone">Số điện thoại</label>
                                <input type="text" name="form[phone]" value="<?= $telephone ?>" class="form-control" id="phone">
                            </div>

                            <div class="form-group">
                                <label for="address">Địa chỉ</label>
                                <input type="text" name="form[address]" value="<?= $address ?>" class="form-control" id="address">
                            </div>
                            <input type="hidden" name="form[id]" value=" <?php echo $id ?> ">
                            <input type="hidden" id="form[token]" name="form[token]" value="1599258345">
                            <button type="submit" id="submit" name="submit" value="Cập nhật thông tin" class="btn btn-solid btn-sm">Cập nhật thông tin</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>