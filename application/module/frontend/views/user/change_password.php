<?php
$moduleName     = $_GET['module'];
$controllerName = $_GET['controller'];


$linkAccount        = URL::createLink($moduleName, $controllerName, 'account');
$linkHistory        = URL::createLink($moduleName, $controllerName, 'history');
$linkChangePassword = URL::createLink($moduleName, $controllerName, 'changePassword');
$changePassword = URL::createLink($moduleName, $controllerName, 'changePassword');



$fullname     = $this->item['fullname'];
$newPassword  = Helper::randomString(12);
$linkCancel   = URL::createLink($moduleName, 'user', 'account');
$buttonCancel = Helper::button($linkCancel, 'btn btn-sm btn-danger mt-2', 'Cancel', 'no-js');


$id =  $_SESSION['user']['info']['id'];






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
                            <li class=""><a href=" <?php echo $linkAccount ?> ">Thông tin tài khoản</a></li>
                            <li class="active"><a href="<?php echo $linkChangePassword ?> ">Thay đổi mật khẩu</a></li>
                            <li class=""><a href=" <?php echo $linkHistory ?> ">Lịch sử mua hàng</a></li>
                            <li class=""><a href=" <?php echo $linkLogOut ?> ">Đăng xuất</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="dashboard-right">

                <?php echo isset($this->error)?'<ul class="alert error-public alert-danger"> <li> '. $this->error.'</li> </ul>':'' ;?>
                <?php
                
                if(Session::get('pass') != ''){

                    echo '<ul class="alert error-public alert-danger"> <li> ' . Session::get('pass') . '</li> </ul>' ;
                }

                Session::delete('pass');
                 ?>
                    
                   
                    <div class="row">
                        <div class="col">
                            <form action=" <?php echo $changePassword ?> " method="post">
                                <div class="card card-info card-outline">
                                    <!-- <div class="card-header"></div> -->

                                    <div class="form-group row align-items-center">
                                        <label class="col-sm-2 col-form-label text-sm-right">Mật khẩu cũ</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm mb-0" name="form[old-password]" value="">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-sm-2 col-form-label text-sm-right">Mật khẩu mới</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm mb-0" name="form[new-password]" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-sm-right">Nhập lại</label>

                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm mb-0" name="form[enter-password]" value="">
                                            <input type="hidden" name="form[token]" value="<?php echo time() ?>">
                                            <input type="hidden" name="form[id]" value="<?php echo $id ?>">

                                            <div class="xuongdong">
                                                <button type="submit" class="btn btn-sm btn-success mt-2">Save</button>
                                                <?= $buttonCancel ?>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
    </div>
</section>