<?php
$moto_id = $_GET['moto_id'];

$mytime = getdate(date("U"));
$date = "$mytime[weekday], $mytime[month], $mytime[mday], $mytime[year]";

require_once PATH_PUBLIC . "rating/db.inc.php";
// echo "SELECT id FROM rate WHERE `moto_id`= $moto_id";
$sql = $conn->query("SELECT id FROM rate WHERE `moto_id`= $moto_id");
$numR = $sql->num_rows;

$sql = $conn->query("SELECT SUM(userReview) AS total FROM rate WHERE `moto_id`= $moto_id");
$data = $sql->fetch_array();
$total = $data["total"];

$avg = '';
if ($numR  != 0) {
    if (is_nan(round(($total / $numR), 1))) {
        $avg = 0;
    } else {
        $avg = round(($total / $numR), 1);
    }
} else {
    $avg = 0;
}

//thong ke
for ($i = 0; $i < 5; $i++) {
    $so   = $i + 1;
    $sql  = $conn->query("SELECT id FROM rate WHERE `moto_id`= $moto_id AND `userReview`= $so");
    $numR = $sql->num_rows;

    $arr1[$so]  = $numR;
}


$sum = array_sum($arr1);

//!=================================================== END PHP =======================================================
?>


<?php
$xhtmlRelateMoto = '';
$i = 0;
foreach ($this->relateMoto as $key => $value) {
    $i++;
    $xhtmlRelateMoto .= '<div class="col-xl-2 col-md-4 col-sm-6">';
    $xhtmlRelateMoto .= Helper::createRowProduct($value['name'], $value['sale_off'], $value['id'], $value['picture'], $value['price'], 5, 'wight_bottom');
    $xhtmlRelateMoto .= '</div>';
    if ($i == 8) break;
}

$arrValue        = $this->infoMoto;
$quantity        = $this->arrParam['quantity'];
$id              = $arrValue['id'];
//$picture         = $picture = URL_UPLOAD . 'moto' . DS . $arrValue['picture'];
$name1            = $arrValue['name'];
$price           = ($arrValue['price']);
$newPrice        = number_format($price - ($price * $arrValue['sale_off'] / 100));
$newPrice1       = ($price - ($price * $arrValue['sale_off'] / 100));
$linkOrder       = URL::createLink('frontend', 'user', 'order', ['moto_id' => $arrValue['id'], 'price' => $newPrice1]);
$price1          = number_format($arrValue['price']);
$saleOff         = $arrValue['sale_off'];
$sortDescription = $arrValue['short_description'];
$description     = $arrValue['description'];
$gallery = json_decode($arrValue['gallery']);

if (!empty($gallery)) {
    foreach ($gallery as $key => $value) {
        $dir = URL_UPLOAD . 'gallery/' . $value;
        $img .= '<li><img src="' . $dir . '"/></li>';
    }
}



$arrImg = '
                <div class="container xyz">
                    <div class="exzoom hidden" id="exzoom">
                        <div class="exzoom_img_box">
                            <ul class="exzoom_img_ul">
                            ' . $img . '
                            </ul>
                        </div>
                        <div class="exzoom_nav"></div>
                        <p class="exzoom_btn">
                            <a href="javascript:void(0);" class="exzoom_prev_btn"> < </a>
                            <a href="javascript:void(0);" class="exzoom_next_btn"> > </a>
                        </p>
                    </div>
                </div>
        ';


$xhtml           = '
            <div class="col-lg-9 col-sm-12 col-xs-12">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="filter-main-btn mb-2"><span class="filter-btn"><i class="fa fa-filter" aria-hidden="true"></i> filter</span></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-xl-4">
                       
                        ' . $arrImg . '
				
                    </div>
                    <div class="col-lg-8 col-xl-8 rtl-text">
                        <div class="product-right">
                            <h2 class="mb-2">' . $name1 . '</h2>
                            <h4><del>' . $price1 . ' đ</del><span> -' . $saleOff . '%</span></h4>
                            <h3 class="price">' . $newPrice . ' đ</h3>
                            <div class="product-description border-product">
                                <h6 class="product-title">Số lượng</h6>
                                <div class="qty-box">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <button type="button" class="btn quantity-left-minus" data-type="minus" data-field="">
                                                <i class="ti-angle-left"></i>
                                            </button>
                                        </span>
                                        <input type="text" name="quantity" class="quantity form-control input-number" value="1" data-id="' . $id . '">
                                        <span class="input-group-prepend">
                                            <button type="button" class="btn quantity-right-plus" data-type="plus" data-field="">
                                                <i class="ti-angle-right"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="product-buttons" data-id="' . $id . '">
                                <a class="btn btn-buy btn-solid ml-0"  ><i class="fa fa-cart-plus"></i> Chọn mua</a>
                            </div>
                            <div class="border-product">' . $sortDescription . '</div>
                        </div>
                    </div>
                </div>
            </div>
            <section class="tab-product m-0">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-lg-12">
                            <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-toggle="tab" href="#top-home" role="tab" aria-selected="true">Mô tả sản phẩm</a>
                                    <div class="material-border"></div>
                                </li>
                            </ul>
                            <div class="tab-content nav-material" id="top-tabContent">
                                <div class="tab-pane fade show active ckeditor-content" id="top-home" role="tabpanel" aria-labelledby="top-home-tab">
                                ' . $description  . '
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div> 
            ';

$motoName      = $this->infoMoto['name'];



$xhtmlSpecial1 = Helper::createSpecialMoto($this->specialMoto1);
$xhtmlSpecial2 = Helper::createSpecialMoto($this->specialMoto2);
$xhtmlNewMoto1 = Helper::createSpecialMoto($this->newMoto1);
$xhtmlNewMoto2 = Helper::createSpecialMoto($this->newMoto2);



//!=================================================== END PHP =======================================================
?>
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2 class="py-2"><?php echo $motoName ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="section-b-space">
    <div class="collection-wrapper">
        <div class="container">
            <div class="row">
                <?php echo $xhtml ?>

                <?php require_once 'elements/rightside.php' ?>
            </div>




            <div id="comment_fb">
                <div class="fb-comments" data-href="https://www.zendvn.com/" data-width="" data-numposts="5"></div>
            </div>


            <!-- RATING -->
            <div class="container rating">
                <div class="rating-review">
                    <div class="tri table-flex">
                        <table>
                            <div class="title-rating"><?php echo $name1 ?> </div>
                            <tbody class="form-rating">
                                <tr>
                                    <td>
                                        <div class="rnb rvl">
                                            <h3> <?php echo $avg; ?>/5.0</h3>
                                        </div>
                                        <div class="pdt-rate">
                                            <div class="pro-rating">
                                                <div class="clearfix rating mart8">
                                                    <div class="rating-stars">
                                                        <div class="grey-stars">
                                                        </div>
                                                        <div class="filled-stars" style="width:<?php echo $avg * 20; ?>%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="rnrn">
                                            <p class="rars"><?php if ($numR == 0) {
                                                                echo "No";
                                                            } else {
                                                                echo $sum;
                                                            } ?> Reviews</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="rpb">
                                            <div class="rnpb">
                                                <label>5 <i class="fa fa-star"></i></label>
                                                <div class="ropb">
                                                    <div class="ripb" style="width:<?php echo ($arr1[5] * 100) / $sum; ?>%">
                                                    </div>
                                                </div>
                                                <div class="label"> (<?php echo $arr1[5]; ?>)</div>
                                            </div>
                                            <div class="rnpb">
                                                <label>4 <i class="fa fa-star"></i></label>
                                                <div class="ropb">
                                                    <div class="ripb" style="width:<?php echo ($arr1[4] * 100) / $sum; ?>%"> </div>
                                                </div>
                                                <div class="label"> (<?php echo $arr1[4]; ?>)</div>
                                            </div>
                                            <div class="rnpb">
                                                <label>3 <i class="fa fa-star"></i></label>
                                                <div class="ropb">
                                                    <div class="ripb" style="width:<?php echo ($arr1[3] * 100) / $sum; ?>%"> </div>
                                                </div>
                                                <div class="label"> (<?php echo $arr1[3]; ?>)</div>
                                            </div>
                                            <div class="rnpb">
                                                <label>2<i class="fa fa-star"></i></label>
                                                <div class="ropb">
                                                    <div class="ripb" style="width:<?php echo ($arr1[2] * 100) / $sum; ?>%"> </div>
                                                </div>
                                                <div class="label"> (<?php echo $arr1[2]; ?>)</div>
                                            </div>
                                            <div class="rnpb">
                                                <label>1 <i class="fa fa-star"></i></label>
                                                <div class="ropb">
                                                    <div class="ripb" style="width:<?php echo ($arr1[1] * 100) / $sum; ?>%"> </div>
                                                </div>
                                                <div class="label"> (<?php echo $arr1[1]; ?>)</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="rrb">
                                            <p>Please review our Product</p>
                                            <button class="rbtn opmd">Add Reviews</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="review-modal" style="display:none">
                            <div class="review-bg">
                            </div>
                            <div class="rmp">
                                <div class="rpc">
                                    <span><i class="fas fa-times"></i></span>
                                </div>
                                <div class="rps" align="center">
                                    <i class="fa fa-star" data-index="0" style="display:none"></i>
                                    <i class="fa fa-star" data-index="1"></i>
                                    <i class="fa fa-star" data-index="2"></i>
                                    <i class="fa fa-star" data-index="3"></i>
                                    <i class="fa fa-star" data-index="4"></i>
                                    <i class="fa fa-star" data-index="5"></i>
                                </div>
                                <input type="hidden" value="" class="starRateV">
                                <input type="hidden" value="<?php echo $date ?>" class="rateDate">
                                <input type="hidden" value="<?php echo $id ?>" class="moto_id">
                                <div class="rptf" align="center">
                                    <input type="text" class="raterName" placeholder="Enter Your name ...">
                                </div>
                                <div class="rptf" align="center">
                                    <textarea class="rateMsg" id="rate-field" placeholder="Describe your Expecrirnce"></textarea>
                                </div>
                                <div class="rate-error" align="center"></div>
                                <div class="rpsb" align="center">
                                    <button class="rpbtn">Post Reviews</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="bri">
                        <div class="uscm">
                            <?php
                            $sqlp = "SELECT * FROM rate WHERE `moto_id`= $moto_id ORDER BY `id` ASC LIMIT 0, 3";
                            $result = $conn->query($sqlp);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <div class="uscm-secs">
                                        <div class="us-img">
                                            <p> <?= strtoupper(substr($row['userName'], 0, 1)) ?> </p>
                                        </div>
                                        <div class="uscms">
                                            <div class="us-rate">
                                                <div class="pdt-rate">
                                                    <div class="pro-rating">
                                                        <div class="clearfix rating mart8">
                                                            <div class="rating-stars">
                                                                <div class="grey-stars">
                                                                </div>
                                                                <div class="filled-stars" style="width:<?= $row['userReview'] * 20 ?>%">

                                                                </div>
                                                            </div>
                                                            <div class="tick"><i class="fa fa-check-circle"></i><span>Đã mua hàng tại kieule.zdemo.xyz</span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="us-cmt">
                                                    <p><?= $row['userMessage'] ?></p>
                                                </div>
                                                <div class="us-nm">
                                                    <p><i>By <span class="cmnm"><?= $row['userName'] ?></span> on <span class="cmdt"><?= $row['dateReviewed'] ?></span> </i></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            } ?>
                            <button class="see-more">XEM THÊM CÁC ĐÁNH GIÁ KHÁC</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END RATING -->

            <?php require_once 'elements/related.php' ?>
        </div>
    </div>
</section>