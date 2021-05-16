<?php

 $module     = $_GET['module'];
  $controller = $_GET['controller'];


$linkAccount        = URL::createLink($module, $controller, 'account');
$linkHistory        = URL::createLink($module, $controller, 'history');
$linkChangePassword = URL::createLink($module, $controller, 'changePassword');
$linkAction         = URL::createLink($module, $controller, 'changePassword');

foreach ($this->items as $value) {

    $id         = $value['id'];
    $motos      = json_decode($value['motos']);
    $prices     = json_decode($value['prices']);
    $quantities = json_decode($value['quantities']);
    $names      = json_decode($value['names']);
    $pictures   = json_decode($value['pictures']);
    $status     = $value['status'];
    $date       = $value['date'];
    $totalPrice = 0;
    $tr         = '';
    foreach ($motos as $keyB => $valueB) {

        $nameB      = $names[$keyB];
        $priceB     = $prices[$keyB];
        $pictureB   = URL_UPLOAD . '/moto' . '/' . $pictures[$keyB];
        $quantitieB = $quantities[$keyB];
        $sumB       = $priceB * $quantitieB;
        $totalPrice +=  $sumB;
        $tr .= ' <tr>
                    <td><a href="#"><img src="' . $pictureB . '" alt="' .  $nameB . '" style="width: 80px"></a></td>
                    <td style="min-width: 200px">' . $nameB . '</td>
                    <td style="min-width: 100px">' . number_format($priceB)  . ' đ</td>
                    <td>' . $quantitieB . '</td>
                    <td style="min-width: 150px">' . number_format($sumB)  . ' đ</td>
                </tr>';
    }
    $xhtml .= '
                <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <button style="text-transform: none;" class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#' . $id . '">Mã đơn hàng:
                            ' . $id . '</button>&nbsp;&nbsp;Thời gian: ' . $date . '
                    </h5>
                </div>
                <div id="' . $id . '" class="collapse" data-parent="#accordionExample" style="">
                    <div class="card-body table-responsive">
                        <table class="table btn-table">

                            <thead>
                                <tr>
                                    <td>Hình ảnh</td>
                                    <td>Tên moto</td>
                                    <td>Giá</td>
                                    <td>Số lượng</td>
                                    <td>Thành tiền</td>
                                </tr>
                            </thead>

                            <tbody>

                                ' . $tr . '
                                
                            </tbody>
                            <tfoot>
                                <tr class="my-text-primary font-weight-bold">
                                    <td colspan="4" class="text-right">Tổng: </td>
                                    <td>' . number_format($totalPrice) . ' đ</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
    ';
}



//!=================================================== END PHP =======================================================
?>

<body>
    <div class="loader_skeleton">
        <div class="typography_section">
            <div class="typography-box">
                <div class="typo-content loader-typo">
                    <div class="pre-loader"></div>
                </div>
            </div>
        </div>
    </div>



    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="page-title">
                        <h2 class="py-2">Lịch sử mua hàng</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- COL LEFT -->
    <section class="faq-section section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="account-sidebar">
                        <a class="popup-btn">Menu</a>
                    </div>
                    <h3 class="d-lg-none">Lịch sử mua hàng</h3>
                    <div class="dashboard-left">
                        <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> Ẩn</span></div>
                        <div class="block-content">
                        <ul>
                                <li class=""><a href=" <?php echo $linkAccount ?> ">Thông tin tài khoản</a></li>
                                <li class=""><a href="<?php echo $linkChangePassword ?> ">Thay đổi mật khẩu</a></li>
                                <li class="active"><a href=" <?php echo $linkHistory ?> ">Lịch sử mua hàng</a></li>
                                <li class=""><a href=" <?php echo $linkLogOut ?> ">Đăng xuất</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="accordion theme-accordion" id="accordionExample">
                        <div class="accordion theme-accordion" id="accordionExample">

                            <?php echo $xhtml ?>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section><!-- END COL LEFT -->





    <!-- tap to top -->
    <div class="tap-top top-cls">
        <div>
            <i class="fa fa-angle-double-up"></i>
        </div>
    </div>
    <!-- tap to top end -->

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.exitintent.js"></script>
    <script src="js/notifyjs/notify.min.js"></script>
    <script src="js/exit.js"></script>
    <script src="js/menu.js"></script>
    <script src="js/lazysizes.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/slick.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap-notify.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/my-custom.js"></script>
    <script>
        function openSearch() {
            document.getElementById("search-overlay").style.display = "block";
            document.getElementById("search-input").focus();
        }

        function closeSearch() {
            document.getElementById("search-overlay").style.display = "none";
        }
    </script>
</body>