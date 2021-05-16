<?php



$message	= '';
switch ($this->arrParam['type']) {
	case 'register-success':
		$message	= 'Tài khoản của bạn đã được tạo thành công. Xin vui lòng chờ kích hoạt từ người quản trị!';
		break;
	case 'not-permission':
		$message	= 'Bạn không có quyền truy cập vào chức năng đó!';
		break;
	case 'not-url':
		$message	= 'Đường dẫn không hợp lệ!';
		break;
	case 'dat_hang_thanh_cong':
		$message	= 'Bạn đã đặt hàng thành công. Xin cảm ơn!';
		break;
}

$linkHome = URL::createLink('frontend', 'index', 'index');


//!=================================================== END PHP =======================================================
?>




<?php
$xhtml = '';
if ($this->arrParam['type'] == 'dat_hang_thanh_cong') {
	$error404 = '';
} else {
	$error404 = '404';
}
if ($this->arrParam['type'] != 'register-success') {
	$xhtml = '<section class="p-0">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<div class="error-section">
								<h1>' . $error404 . '</h1>
								<h2>' . $message . '</h2>
								<a href=" ' . $linkHome . '" class="btn btn-solid">Quay lại trang chủ</a>
							</div>
						</div>
					</div>
				</div>
			</section>
			';
}
if ($this->arrParam['type'] == 'register-success') {
	$xhtml = '<section class="p-0">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<div class="error-section">
							
								<h2>' . $message . '</h2>
								<a href=" ' . $linkHome . '" class="btn btn-solid">Quay lại trang chủ</a>
							</div>
						</div>
					</div>
				</div>
			</section>
			';
}
?>

<?= $xhtml ?>
