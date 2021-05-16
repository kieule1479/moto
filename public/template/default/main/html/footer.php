<?php

//===== DANH MỤC NỔI BẬT ======
$model        = new Model();
$query        = "SELECT `name`,`id` FROM `" . TBL_CATEGORY . "` WHERE `status`= '1' ORDER BY `ordering` LIMIT 0,4";
$arrCategory  = $model->fetchAll($query);
$xhtml = '';
foreach ($arrCategory as $value) {
    $id     = $value['id'];
    $name   = $value['name'];
    $action = 'index&category_id=' . $id;
    $link   = URL::createLink('frontend', 'moto', $action);
    $xhtml .= sprintf('<li><a href="%s">%s</a></li>', $link, $name);
} //=====END DANH MỤC NỔI BẬT ======



//===== DANH MỤC NỔI BẬT ======
$queryTelephone = "SELECT `name`,`id`, `telephone` FROM `" . TBL_INFO . "` WHERE `status`= '1' ORDER BY `ordering` LIMIT 0,2";


$arrTelephone  = $model->fetchAll($queryTelephone);
$xhtmlTelephone = '';
foreach ($arrTelephone as $value) {

    $id     = $value['id'];
    $name   = $value['name'];
    $telephone   = $value['telephone'];
    $xhtmlTelephone .= sprintf(' <li><i class="fa fa-phone"></i>%s: <a href="tel:%s">%s</a></li>', $name, $telephone, $telephone);
} //=====END DANH MỤC NỔI BẬT ======
//!=================================================== END PHP =======================================================
?>

<footer class="footer-light mt-5 tat-ovr">
    <section class="section-b-space light-layout">
        <div class="container">
            <div class="row footer-theme partition-f">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-title footer-mobile-title">
                        <h4>Giới thiệu</h4>
                    </div>
                    <div class="footer-contant">
                        <div class="footer-logo">
                            <h2 style="color: #5fcbc4">YAMAHA MOTOR</h2>
                        </div>

                        <div id="embed_fp">
                            <!-- nhung fanpage -->
                            <!-- Đặt mã này ở bất cứ đâu mà bạn muốn plugin xuất hiện trên trang. -->
                            <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook&tabs&width=340&height=130&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="340" height="130" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                        </div>
                        <p>Showroom: 28 Trần trọng Cung, Quận 7, HCM
                            HOTLINE: 0931.106.538
                        </p>
                    </div>


                </div>
                <div class="col offset-xl-1">
                    <div class="sub-title">
                        <div class="footer-title">
                            <h4>Danh mục nổi bật</h4>
                        </div>
                        <div class="footer-contant">
                            <ul>
                                <?php echo $xhtml ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="sub-title">
                        <div class="footer-title">
                            <h4>Chính sách</h4>
                        </div>
                        <div class="footer-contant">
                            <ul>
                                <li><a href="#">Điều khoản sử dụng</a></li>
                                <li><a href="#">Chính sách bảo mật</a></li>
                                <li><a href="#">Hợp tác phát hành</a></li>
                                <li><a href="#">Phương thức vận chuyển</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="sub-title">
                        <div class="footer-title">
                            <h4>Thông tin</h4>
                        </div>
                        <div class="footer-contant">
                            <ul class="contact-list">
                                <!-- <li><i class="fa fa-phone"></i>Hotline 1: <a href="tel:0905744470">090 5744 470</a></li>
                                <li><i class="fa fa-phone"></i>Hotline 2: <a href="tel:0383308983">0383 308 983</a></li> -->
                                <?php echo $xhtmlTelephone ?>
                                <li><i class="fa fa-envelope-o"></i>Email: <a href="mailto:training@zend.vn" class="text-lowercase">training@zend.vn</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</footer> <!-- footer end -->