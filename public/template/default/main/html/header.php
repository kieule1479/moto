<?php


//===== DANG XUAT - DANG NHAP ======
$userObj      = Session::get('user');
$userInfo     = $userObj['info'];
$linkLogin    = URL::createLink('frontend', 'user', 'login');
$linkRegister = URL::createLink('frontend', 'user', 'register');
$linkLogOut   = URL::createLink('frontend', 'index', 'logout');
$linkAccount  = URL::createLink('frontend', 'user', 'account');
$linkCart     = URL::createLink('frontend', 'user', 'cart');

if (!isset($userObj['login'])) {
	$xhtmlAccount = ' <div class="top-header">
						<ul class="header-dropdown">
							<li class="onhover-dropdown mobile-account">
								<img src="' . $this->_dirImg . '/avatar.png" alt="avatar">
								<ul class="onhover-show-div">
									<li><a href="' . $linkLogin . '">Đăng nhập</a></li>
									<li><a href="' . $linkRegister . '">Đăng ký</a></li>
								</ul>
							</li>
						</ul>
					</div>';
} else {
	$xhtmlAccount = ' <div class="top-header">
						<ul class="header-dropdown">
							<li class="onhover-dropdown mobile-account">
								<img src="' . $this->_dirImg . '/avatar.png" alt="avatar">
								<ul class="onhover-show-div">
									<li><a href="' . $linkAccount . '">' . $userInfo['username'] . '</a></li>
									<li><a href="' . $linkLogOut . '">Đăng xuất</a></li>
								</ul>
							</li>
						</ul>
					</div>';
} //=====END DANG XUAT - DANG NHAP ======



//===== CART ======
$cart      = Session::get('cart');
$totalItem = 0;
if (!empty($cart)) {
	$totalItem = array_sum($cart['quantity']);
} //=====END CART ======



//===== MENU ======
$linkHome     = URL::createLink('frontend', 'index', 'index');

$model        = new model();
$query        = "SELECT `name`,`id` FROM `" . TBL_CATEGORY . "` WHERE `status`= '1' ORDER BY `ordering`";
$arrCategory  = $model->fetchAll($query);


$arrMenu[]    = ['controller' => 'index', 'action' => 'index', 'name' => 'Trang chủ'];
$arrMenu[]    = ['controller' => 'moto', 'action' => 'index', 'name' => 'Moto'];
$arrMenu[]    = ['controller' => 'news', 'action' => 'index', 'name' => 'Tin tức'];
$arrMenu[]    = ['controller' => 'category', 'action' => 'index', 'name' => 'Danh mục', 'child' => $arrCategory];


$xhtmlMenu    = '';
$class        = "";

foreach ($arrMenu as $key => $value) {
	if ($_GET['action'] == $value['action'] && $_GET['controller'] == $value['controller']) {
		$class = "my-menu-link active";
	} else {
		$class = "";
	}
	if (!isset($value['child'])) {
		$linkMenu 	= URL::createLink('frontend', $value['controller'], $value['action']);
		$xhtmlMenu .= '<li><a href="' . $linkMenu . '" class="' . $class . '">' . $value['name'] . '</a></li>';
	} else {
		$linkMenu = URL::createLink('frontend', $value['controller'], $value['action']);
		$xhtmlMenu .= '<li><a href="' . $linkMenu . '" class="' . $class . '">' . $value['name'] . '</a><ul>';
		foreach ($value['child'] as $keyC => $valueC) {
			$linkCatMenu = URL::createLink('frontend', 'moto', 'index', ['category_id' => $valueC['id']]);
			$xhtmlMenu .= '<li><a href="' . $linkCatMenu . '">' . $valueC['name'] . '</a></li>';
		}
		$xhtmlMenu .= '</ul></li>';
	}
} //=====END MENU ======



require_once 'bread_curmb/html/data.php';

$currentBreadCrumb = $arrBreadCrumb[$menuCurrent];
$nameSP            = $arrMenu[$menuCurrent];

if (isset($_GET['category_id'])) {
	$id =  $_GET['category_id'];
}

if (isset($_GET['moto_id'])) {
	$id =  $_GET['moto_id'];
}
if (isset($_GET['news_id'])) {
	$id =  $_GET['news_id'];
}




$lengthBreadCrumb = 1; //count($currentBreadCrumb);
if (isset($_GET['category_id']) || isset($_GET['moto_id']) || isset($_GET['news_id'])) {
	$lengthBreadCrumb = 2;
}


$xhtmlBreadCrumb = '';
$check = 0;

switch ($lengthBreadCrumb) {
	case 1:

		if ($menuCurrent == 'index') {
			$xhtmlBreadCrumb = sprintf('<span>Trang chủ</span>');
		} else {
			$check = 1;
			$xhtmlBreadCrumb = sprintf(
				'
            <a href="' . $link_trang_chu . '">Trang chủ</a>
            <span class="margin" >></span>
            <span>%s</span>',
				$currentBreadCrumb[0]['name']
			);
		}
		break;
	case 2:
		$check = 1;
		$xhtmlBreadCrumb = sprintf(
			'<a href="' . $link_trang_chu . '">Trang chủ</a>
			<span class="margin" >></span>
			<a href="%s">%s</a>
			<span class="margin" >>
			</span><span>%s</span>',
			$currentBreadCrumb[0]['link'],
			$currentBreadCrumb[0]['name'],
			$nameSP['child'][$id]['name']
		);
		break;
	case 3:
		$check = 1;
		$xhtmlBreadCrumb = '<a href="' . $link_trang_chu . '">Trang chủ</a>';
		for ($i = 0; $i < $lengthBreadCrumb - 1; $i++) {
			$xhtmlBreadCrumb .= sprintf('
            <span class="margin" >></span>
            <a href="%s">%s</a>
            ', $currentBreadCrumb[$i]['link'], $currentBreadCrumb[$i]['name']);
		}
		$xhtmlBreadCrumb .= sprintf('<span>></span><span>%s</span>', $currentBreadCrumb[$lengthBreadCrumb - 1]['name']);
		break;
}








//!=================================================== END PHP =======================================================
?>
<header class="my-header sticky">
	<div class="mobile-fix-option"></div>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="main-menu">
					<div class="menu-left">
						<div class="brand-logo">
							<a href="<?php echo $linkHome ?>">
								<h2 class="mb-0" style="color: #5fcbc4">Yamaha</h2>
							</a>
						</div>
					</div>
					<div class="menu-right pull-right">
						<div>
							<nav id="main-nav">
								<div class="toggle-nav"><i class="fa fa-bars sidebar-bar"></i></div>
								<ul id="main-menu" class="sm pixelstrap sm-horizontal">
									<li>
										<div class="mobile-back text-right">Back<i class="fa fa-angle-right pl-2" aria-hidden="true"></i></div>
									</li>
									<?php echo $xhtmlMenu ?>
								</ul>
							</nav>
						</div>
						<?php echo $xhtmlAccount ?>
						<div>
							<div class="icon-nav">
								<ul>
									<li class="onhover-div mobile-search">
										<div>
											<img src="<?php echo $this->_dirImg ?>/search.png" onclick="openSearch()" class="img-fluid blur-up lazyload" alt="">
											<i class="ti-search" onclick="openSearch()"></i>
										</div>
										<div id="search-overlay" class="search-overlay">
											<div>
												<span class="closebtn" onclick="closeSearch()" title="Close Overlay">×</span>
												<div class="overlay-content">
													<div class="container">
														<div class="row">
															<div class="col-xl-12">
																<form action="" method="GET">
																	<div class="form-group">
																		<input type="hidden" name="module" value="frontend">
																		<input type="hidden" name="controller" value="moto">
																		<input type="hidden" name="action" value="index">

																		<input type="text" class="form-control" name="search_moto" id="search-input" placeholder="Tìm kiếm moto...">
																	</div>
																	<button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>

																</form>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</li>
									<li class="onhover-div mobile-cart">
										<div>
											<a href="<?php echo $linkCart ?>" id="cart" class="position-relative">
												<img src="<?php echo $this->_dirImg ?>/cart.png" class="img-fluid blur-up lazyload" alt="cart">
												<i class="ti-shopping-cart"></i>
												<span id='badge' class="badge badge-warning"><?php echo $totalItem ?></span>
											</a>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>

<?php
$xhtmlBR = '';
if ($check == 1) {
	$xhtmlBR = '
			<div class="breadcrumb margin">
				' . $xhtmlBreadCrumb . '
			</div>
			';
}
echo $xhtmlBR;
?>