<?php


$total        = 0;
$xhtml        = '';
$linkContinue = URL::createLink('frontend', 'index', 'index');
$linkCheckOut = URL::createLink('frontend', 'user', 'checkout');


$flag = false;
if (empty($this->motoInCart)) {
    $flag = true;
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
    //$linkRemove = URL::createLink('frontend', 'user', 'removeItemFromCart', ['id' => $id]);

    $xhtml .= '
        <tr>
        <td>
            <a href="' . $linkDetail . '"><img src="' . $picture . '" alt="' . $name . '"></a>
        </td>
        <td><a href="' . $linkDetail . '">' . $name . '</a>
            <div class="mobile-cart-content row">
                <div class="col-xs-3">
                    <div class="qty-box">
                        <div class="input-group">
                            <input type="number" name="quantity" value="' . $quantity . '" class="cart-quantity form-control input-number" data-id="' . $id . '" data-price="' . $newPrice . '" id="quantity-' . $id . '" min="1">
                        </div>
                    </div>
                </div>
                <div class="col-xs-3">
                    <h2 class=" td-color text-lowercase">' . number_format($price) . ' đ</h2>
                </div>
                <div class="col-xs-3">
                    <h2 class="td-color text-lowercase">
                        <p class="icon"><i class="ti-close"></i></p>
                    </h2>
                </div>
            </div>
        </td>
        <td>
            <h2 class=" cart-price-' . $id . ' text-lowercase">' . number_format($price) . ' đ</h2>
        </td>
        <td>
            <div class="qty-box">
                <div class="input-group">
                    <input type="text" name="quantity" value="' . $quantity . '" class="cart-quantity form-control input-number" data-id="' . $id . '" data-price="' . $price . '" id="quantity-' . $id . '" min="1" readonly>
                </div>
            </div>
        </td>
        <td>
        <p class="icon"  ><i  class="ti-close clear" data-id = "' . $id . '" ></i></p>
        </td>
        <td>
            <h2 class=" cart-total-price-' . $id . ' td-color text-lowercase">' . number_format($totalPrice) . ' đ</h2>
        </td>
    </tr>
        ';
}

?>

<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2 class="py-2">Giỏ hàng</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="<?php echo $linkCheckOut ?>" method="POST" name="admin-form" id="admin-form">
    <section class="cart-section section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table cart-table table-responsive-xs">
                        <thead>
                            <tr class="table-head">
                                <th scope="col">Hình ảnh</th>
                                <th scope="col">Tên moto</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Số Lượng</th>
                                <th scope="col"></th>
                                <th scope="col">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $xhtml ?>
                        </tbody>

                    </table>
                    <table class="table cart-table table-responsive-md">
                        <tfoot>
                            <tr>
                                <td>Tổng :</td>
                                <td>
                                    <h2 class=" total text-lowercase"><?php echo number_format($total) ?> đ</h2>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row cart-buttons">
                <div class="col-6"><a href="<?php echo $linkContinue ?>" class="btn btn-solid" style="margin-left:450px">Tiếp tục mua sắm</a></div>

                <?php
                $dathang = '';
                if ($flag == false) {
                    $dathang = ' <div class="col-6"><button type="submit" class="btn btn-solid">Đặt hàng</button></div>';
                }
                echo $dathang;
                ?>

            </div>
        </div>
    </section>
</form>