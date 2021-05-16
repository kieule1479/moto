<?php
class Helper
{


	//===== SLIDER ======
	public static function slider($namePicture)
	{

		$dirPicture = URL_UPLOAD . 'slider/' . $namePicture;
		$xhtml = '<div>
					<a href="" class="home text-center">
						<img style="width:1920px, height:718px, display: none !important" src="' . $dirPicture . '" alt="" class="bg-img blur-up lazyload">
					</a>
				</div>  ';
		return $xhtml;
	}


	//===== COL ======
	public static function col($for, $name, $input)
	{
		$xhtml = sprintf('<div class="col-md-6">
							<label for="' . $for . '" class="required">' . $name . '</label>
							' . $input . '
						</div>');
		return $xhtml;
	}

	//===== RANDOM STRING ======
	public static function randomString($length = 8)
	{
		$arrCharacter = array_merge(range('a', 'z'), range(0, 9), range('A', 'Z'));
		$arrCharacter = implode('', $arrCharacter);
		$arrCharacter = str_shuffle($arrCharacter);

		$result       = substr($arrCharacter, 0, $length);
		return $result;
	}

	//===== SHOW ITEM STATUS ======
	public static function showItemStatus($value, $link, $id)
	{
		$class = 'danger';
		$icon = 'minus';
		if ($value == 1) {
			$class = 'success';
			$icon = 'check';
		}
		$xhtml = '<a href="javascript:changeStatus(\'' . $link . '\')" class="status-' . $id . ' my-btn-state rounded-circle btn btn-sm btn-' . $class . '"><i class="fas fa-' . $icon . '"></i></a>';
		return $xhtml;
	}
	//===== SHOW ITEM STATUS ======
	public static function showItemSpecial($value, $link, $id)
	{
		$class = 'danger';
		$icon = 'minus';
		if ($value == 1) {
			$class = 'success';
			$icon = 'check';
		}
		$xhtml = '<a href="javascript:changeSpecial(\'' . $link . '\')" class="special-' . $id . ' my-btn-state rounded-circle btn btn-sm btn-' . $class . '"><i class="fas fa-' . $icon . '"></i></a>';
		return $xhtml;
	}

	//===== SHOW ITEM GROUP ACP ======
	public static function showItemGroupACP($value, $link, $id)
	{
		$class = 'danger';
		$icon = 'minus';
		if ($value == 1) {
			$class = 'success';
			$icon = 'check';
		}
		$xhtml = '<a href="javascript:changeGroupACP(\'' . $link . '\')" class="groupACP-' . $id . ' my-btn-state rounded-circle btn btn-sm btn-' . $class . '"><i class="fas fa-' . $icon . '"></i></a>';
		return $xhtml;
	}

	//===== SHOW FILTER BUTTON ======
	public static function showFilterButton($module, $controller, $arr, $currentFilterStatus)
	{
		$xhtml = '';
		foreach ($arr as $key => $value) {
			$link = URL::createLink($module, $controller, 'index', ['status' => $key]);
			$name = '';
			switch ($key) {
				case 'all':
					$name = 'All';
					break;
				case 'active':
					$name = 'Active';
					break;
				case 'inactive':
					$name = 'Inactive';
					break;
			}
			$active = $key == $currentFilterStatus ? 'info' : 'secondary';
			$xhtml .= ' <a href="' . $link . '" class="mr-1 btn btn-sm btn-' . $active . '">' . $name . ' <span class="badge badge-pill badge-light">' . $value . '</span></a>';
		}
		return $xhtml;
	}

	//===== SELECT ======
	public static function select($name, $class, $arrValue, $keySelect = 'default', $style = null, $attribute = '')
	{
		$xhtml = '<select style="' . $style . '" name="' . $name . '" class="' . $class . '" ' . $attribute . '>';
		foreach ($arrValue as $key => $value) {

			if ($key == $keySelect && is_numeric($keySelect)) {
				$xhtml .= '<option selected value = "' . $key . '">' . $value . '</option>';
			} else {
				$xhtml .= '<option value = "' . $key . '">' . $value . '</option>';
			}
		}
		$xhtml .= '</select>';
		return $xhtml;
	}

	//===== SELECT KEY NO NUMBER ======
	public static function selectKeyNoNumber($name, $class, $arrValue, $keySelect = 'default', $style = null, $attribute = '')
	{
		$xhtml = '<select style="' . $style . '" name="' . $name . '" class="' . $class . '" ' . $attribute . '>';
		foreach ($arrValue as $key => $value) {
			if ($key == $keySelect) {
				$xhtml .= '<option selected value = "' . $key . '">' . $value . '</option>';
			} else {
				$xhtml .= '<option value = "' . $key . '">' . $value . '</option>';
			}
		}
		$xhtml .= '</select>';
		return $xhtml;
	}

	// HIGHT LIGHT COL
	public static function highLightCol($input, $searchValue, $key, $arr)
	{
		if (in_array($key, $arr)) {
			$result = $input;
			if ($searchValue != '') {
				$result = preg_replace("/" . preg_quote($searchValue, "/") . "/i", "<mark>$0</mark>", $input);
			}
		} else {
			$result = $input;
		}
		return $result;
	}


	// HIGHT LIGHT
	public static function highLight($input, $searchValue)
	{
		$result = $input;
		if ($searchValue != '') {
			$result = preg_replace("/" . preg_quote($searchValue, "/") . "/i", "<mark>$0</mark>", $input);
		}
		return $result;
	}

	// FORMATE DATE
	public static function formatDate($format, $value)
	{
		$result = '';
		if (!empty($value) && $value != '0000-00-00') {
			$result = date($format, strtotime($value));
		}
		return $result;
	}

	//===== CREATE ROW   ======
	public static function row($labelName, $input, $require = false)
	{

		if ($require == true) $require = 'required';
		$xhtml = ' <div class="form-group row align-items-center">
						<label for="' . $labelName . '" class="col-sm-2 col-form-label text-sm-right ' . $require . '">' . $labelName . '</label>
						<div class="col-xs-12 col-sm-8">
						' . $input . '
						</div>
					</div>';
		return $xhtml;
	}

	//===== CREATE TITLE SORT   ======
	public static function cmsLinkSort($name, $column, $columnPost, $orderPost)
	{
		$img = '';
		$order = ($orderPost == 'desc') ? 'asc' : 'desc';
		if ($column == $columnPost) {
			$img = ' <img src="' . URL_TEMPLATE . 'admin/theme_admin/images/sort_' . $orderPost . '.png" alt=""/>';
			'<h3 style="color:red;font-weight:bold">' . $img . '</h3>';
		}
		$xhtml = '<a href="#" onclick="javascript:sortList(\'' . $column . '\',\'' . $order . '\')">' . $name . $img . '</a>';
		return $xhtml;
	}

	// BUTTON IN ADD GROUP
	public static function button($link, $class, $name, $js = null)
	{
		if ($js == null) {

			$xhtml = ' <a href="javascript:submitForm(\'' . $link . '\')" class="' . $class . '"> ' . $name . '</a>';
		} else {
			$xhtml = ' <a href="' . $link . '" class="' . $class . '"> ' . $name . '</a>';
		}
		return $xhtml;
	}
	//===== BUTTON ======
	public static function button1($type, $id, $name, $value, $value1)
	{
		$xhtml = sprintf('<button type="%s" id="%s" name="%s" value="%s" class="btn btn-solid">%s</button>', $type, $id, $name, $value, $value1);

		return $xhtml;
	}

	//===== INPUT ======
	public static function input($type, $name, $id, $value, $class = null, $attribute = null)
	{
		$strClass = ($class == null) ? '' : 'class="' . $class . '"';
		$xhtml = '<input type="' . $type . '" name="' . $name . '" id="' . $id . '" value="' . $value . '"' . $strClass . $attribute . '>';
		return $xhtml;
	}

	// INPUT PICTURE
	public static function inputPicture($name, $type, $multiple = null)
	{
		$multiple = $multiple == null ? '' : 'multiple';

		$xhtml = '	<div class="hiddenImg">
						<div class="input-group">
							<div class="custom-file">
								
								<input name= "' . $name . '"type="' . $type . '" onchange="readURL(this)" 						class="custom-file-input" id="exampleInputFile" ' . $multiple . '  >
								
								<label class="custom-file-label" for="exampleInputFile">Choose file</label>
								
							</div>
							<div class="input-group-append">
								<span class="input-group-text" id="">Upload</span>
							</div> 
						</div>
						<img   id="blah" class="hiderImg" src="" alt="your image" />
					</div>
					
				';
		return $xhtml;
	}
	// INPUT PICTURE
	public static function inputPictureMultiple($name, $type)
	{
		
		$xhtml = '<input name="'.$name.'" type="'.$type.'"  multiple id="gallery-photo-add">				
				  <div class="gallery"></div>
				 ';
		return $xhtml;
	}

	//===== FORM DESCRIPTION ======
	public static function rowTextarea($for, $class, $labelName, $id, $name, $rows, $value)
	{
		$xhtml = '
						<div class="form-group row">
							<label for="' . $for . '" class="' . $class . '">' . $labelName . '</label>
							<div class="col-xs-12 col-sm-8">
								<textarea id="' . $id . '" name="' . $name . '" class="form-control form-control-sm" rows="' . $rows . '">' . $value . '</textarea>
							</div>
						</div>';
		return $xhtml;
	}

	//===== SHOW ITEM ORDERING ======
	public static function showItemOrdering($id, $ordering)
	{
		$xhtml = Helper::input("number", "chkOrdering[$id]", "chkOrdering[$id]", $ordering, 'chkOrdering form-control form-control-sm m-auto text-center', 'style="width: 65px" data-id="' . $id . '" min="1"');
		return $xhtml;
	}

	// CREATE ITEM HISTORY
	public static function showItemHistory($by, $time)
	{
		$time = Helper::formatDate(DATETIME_FORMAT, $time);
		$xhtml = '
		  <p class="mb-0 history-by"><i class="far fa-user"></i> ' . $by . '</p>
		  <p class="mb-0 history-time"><i class="far fa-clock"></i> ' . $time . '</p>
		  ';
		return $xhtml;
	}

	//===== CREATE NOTIFY ======
	public static function createNotify($type, $message)
	{
		return ['type' => $type, 'message' => $message];
	}

	//===== SHOW TOAST MESSAGE ======
	public static function showToastMessage()
	{
		$message = Session::get('notify') ?? '';

		Session::delete('notify');
		if (!empty($message)) {

			return "showToast(\"" . $message['type'] . "\", \"" . $message['message'] . "\")";
		}
	}

	//===== SHOW SMALL BOX DASHBOARD ======
	public static function showBoxDashboard($name, $itemsCount, $link, $bgClass, $icon)
	{
		$xhtml = sprintf('
        <div class="small-box %s">
            <div class="inner">
                <h3>%s</h3>
                <p>%s</p>
            </div>
            <div class="icon text-white">
                <i class="ion %s"></i>
            </div>
            <a href="%s" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
        ', $bgClass, $itemsCount, $name, $icon, $link);

		return $xhtml;
	}

	//===== CREATE SIDE BAR MENU ITEM ======
	public static function menuSidebar($controller, $action, $menuItem)
	{
		$xhtml = '';
		if (isset($menuItem['child'])) {
			if ($menuItem['data-active'] == $controller) {
				$activeParent = 'active';
				$menuOpen = 'menu-open';
			}
			$xhtml .= ' 
						  <li class="nav-item has-treeview ' . $menuOpen . '">
							<a href="' . $menuItem['link'] . '" class="nav-link ' . $activeParent . '" data-active="' . $menuItem['data-active'] . '">
								<i class="icon-color nav-icon fas fa-' . $menuItem['icon'] . '"></i>
								<p>' . $menuItem['name'] . '<i class="fas fa-angle-left right"></i></p>
							</a>
							<ul class="nav nav-treeview"> ';
			foreach ($menuItem['child'] as $menuItemChild) {
				$activeChild = ($activeParent && $menuItemChild['data-active'] == $action) ? 'active' : '';
				$xhtml .= '
						 <li class="nav-item">
							<a href="' . $menuItemChild['link'] . '" class="nav-link ' . $activeChild . '" data-active="' . $menuItemChild['data-active'] . '">
							<ul>
							 	<i class="nav-icon fas fa-' . $menuItemChild['icon'] . '"></i>
								<p>' . $menuItemChild['name'] . '</p>
							</ul>
							</a>
						</li>
						';
			}
			$xhtml .= '</ul></li>';
		} else {
			$activeParent = $menuItem['data-active'] == $controller ? 'active' : '';
			$xhtml .= sprintf('
			 <li class="nav-item">
				 <a href="%s" class="nav-link %s" data-active="%s">
					 <i class="nav-icon fas fa-%s"></i>
					 <p>%s</p>
				 </a>
			 </li>
			 ', $menuItem['link'], $activeParent, $menuItem['data-active'], $menuItem['icon'], $menuItem['name']);
		}
		return $xhtml;
	}
	//===== SHOW USER INFO ======
	public static function showUserInfo($arr)
	{
		$xhtml = '';
		foreach ($arr as $item) {
			$xhtml .= sprintf('<p class="mb-0"><b>%s</b>: %s</p>', $item['name'], $item['value']);
		}
		return $xhtml;
	}

	//===== LAY SO TU ======
	public static function myTruncate($description)
	{
		$numWords1 =  str_word_count($description, 0);
		$numWords = 4;
		preg_match("/(\S+\s*){0,$numWords}/", $description, $regs);
		$shortDesc = trim($regs[0]);
		if ($numWords1 > 5) {
			$shortDesc = $shortDesc . '...';
		}
		return $shortDesc;
	}

	//===== TAO MOI HANG SAN PHAM ======
	public static function createRowProduct($name, $saleOff, $id, $image, $price, $rating = null, $style= null, $searchValue = null)
	{
		 
		if($rating==null){
			$rating= 5;
		}
		//echo $searchValue;
		$link      = URL::createLink('frontend', 'moto', 'detail', ['moto_id' => $id]);
		$newPrice  = ($price - ($price * $saleOff / 100));
		$name = Helper::highLight($name, $searchValue);
		$shortname = Helper::myTruncate($name); //$shortname = substr($name, 0, 50) . '...';
		$picture   = URL_UPLOAD . 'moto' . DS . $image;
		$sale      = $saleOff > 0 ? ' <span class="lable4 badge badge-danger" style="height:50px"> -' . $saleOff . '%</span>' : '';
		$priceHidden     = $saleOff >= 0 ? '<del>' . number_format($price) . ' đ</del>' : '';
		$xhtml     = '
		 <div class="product-box '.$style.' ">
			 <div class="img-wrapper">
				 <div class="lable-block">
					' . $sale . '
				 </div>
				 <div class="fronte">
					 <a href="' . $link . '">
						 <img style="display: block !important ;" src="' . $picture . '" class="img-fluid blur-up lazyload bg-img" alt="product">
					 </a>
				 </div>
				 <div class="cart-info cart-wrap">
				 
					 <a href="#" title="Add to cart"><i class="ti-shopping-cart add-to-cart" data-id="' . $id . '"></i></a>
					 <a href="#"  title="Quick View"><i class="ti-search quick-view" data-id="' . $id . '" data-toggle="modal" data-target="#quick-view"></i></a>
				 </div>
			 </div>
			 <div class="product-detail">
				 <div class="rating">
							<div class="rating-stars">
								<div class="grey-stars"></div>							
								<div class="filled-stars" style="width:'. $rating * 20 .'%"></div>
							</div>
				 </div>
				 <a href="' . $link . '" title="' . $name . '">
					 <h6>' . $shortname . '</h6>
				 </a>
				 <h4 class="text-lowercase">' . number_format($newPrice) . ' đ ' . $priceHidden  . ' </h4>
			 </div>
		 </div>
		 ';
		return $xhtml;
	}

	//===== CREATE CATEGORY ITEM ======
	public static function createCategoryItem($id, $name, $class)
	{
		$link = URL::createLink('frontend', 'moto', 'index', ['category_id' => $id]);
		$xhtml = '
				  <div class="custom-control custom-checkbox collection-filter-checkbox pl-0 category-item">
					  <a class="' . $class . '" href="' . $link . '">' . $name . '</a>
				  </div>
				  ';

		return $xhtml;
	}

	//===== TIEU DE DANH MUC NOI BAT ======
	public static function tieuDeDanhMucNoiBat($class, $href, $data_category, $name)
	{
		$xhtml = sprintf('<li class="%s"><a href="tab-category-%s" class="my-product-tab" data-category="%s">%s</a></li>', $class, $href, $data_category, $name);
		return $xhtml;
	}

	//===== CREATE SPECIAL moto ======
	public static function createSpecialMoto($arrValue)
	{
		$xhtml = '<div>';
		foreach ($arrValue as $key => $value) {
			$picture = URL_UPLOAD . 'moto' . DS . $value['picture'];
			$link = URL::createLink('frontend', 'moto', 'detail', ['moto_id' => $value['id']]);
			$linkOrder = URL::createLink('frontend', 'moto', 'order', ['moto_id' => $value['id'], 'price' => $value['price']]);
			$newPrice = ($value['price'] - ($value['price'] * $value['sale_off'] / 100));
			$rating = $value['rating'];
			if($rating==null){
				$rating= 5;
			}
			$xhtml .= '
                <div class="media">
                    <a href="' . $link . '">
                        <img style="width:130px; height:120px"  class="img-fluid blur-up lazyload" src="' . $picture . '" alt="' . $value['name'] . '"></a>
                    <div class="media-body align-self-center">
                        <div class="rating">
							<div class="rating-stars">
								<div class="grey-stars"></div>							
								<div class="filled-stars" style="width:'. $rating * 20 .'%"></div>
							</div>
                        </div>
                        <a href="' . $link . '" title="' . $value['name'] . '">
                            <h6>' . $value['name'] . '</h6>
                        </a>
                        <h4 class="text-lowercase">' . number_format($newPrice) . ' đ</h4>
                    </div>
                </div>
                ';
		}
		$xhtml .= '</div>';
		return $xhtml;
	}

	//===== SHOW CATEGORY  ======
	public static function showCategory($img1, $name, $id)
	{
		$img = URL_PUBLIC . 'files' . DS .  'category' . DS . $img1;
		$xhtml = ' <div class="product-box">
					   <div class="img-wrapper">
						   <div class="front">
							   <a href="index.php?module=frontend&controller=moto&action=index&category_id=' . $id . '"><img src="' . $img . '" class="img-fluid blur-up lazyload bg-img" alt=""></a>
						   </div>
					   </div>
					   <div class="product-detail">
						   <a href="list.html"><h4>' . $name . '</h4></a>
					   </div>
				   </div>';
		return $xhtml;
	}

	// CREATE ITEM CHECKBOX
	public static function showItemCheckbox($id)
	{
		$xhtml = '
		<div class="custom-control custom-checkbox">
			<input class="custom-control-input" type="checkbox" id="checkbox-' . $id . '" name="checkbox[]" value="' . $id . '">
			<label for="checkbox-' . $id . '" class="custom-control-label"></label>
		</div>
		';
		return $xhtml;
	}
	//===== SHOW PICTURE ======
	public static function showPicture($nameFolder, $picture)
	{
		$file = PATH_UPLOAD . $nameFolder . DS . '' . $picture;
		if (!file_exists($file)) {
			$xhtml = '<img style="width:120px; height:90px" src="' . URL_UPLOAD . $nameFolder . DS . 'default.jpg">';
		} else {
			$xhtml = '<img style="width:120px; height:90px" src="' . URL_UPLOAD . $nameFolder . DS . '' . $picture . '">';
		}
		return $xhtml;
	}

	// SHOW SPECIAL
	public static function showSpecial($link, $state)
	{
		$classDOM = is_numeric($state) ? 'my-btn-state btn-special' : '';
		$classDOM1 = !(is_numeric($state)) ? ' btn-status' : '';
		$class = 'success';
		$icon = 'check';
		if ($state == 'inactive' || $state == '0') {
			$class = 'danger';
			$icon = 'minus';
		}
		// <a href="i" class="my-btn-state rounded-circle btn btn-sm btn-danger"><i class="fas fa-minus"></i></a>
		$xhtml = '
				  <a href="' . $link . '" class="' . $classDOM . $classDOM1 . ' rounded-circle  btn btn-sm btn-' . $class . '"><i class="fas fa-' . $icon . '"></i></a>
				  ';
		return $xhtml;
	}

	//===== SHOW ACTION BUTTON ======
	public static function showActionButton($moduleName, $controllerName, $id)
	{
		$templateButton = [
			'view'          => [
				'class' => 'btn-primary',
				'icon' => 'eye',
				'text' => 'View',
				'link' => URL::createLink($moduleName, $controllerName, 'detail', ['id' => $id])
			],

			'edit'          => [
				'class' => 'btn-info',
				'icon' => 'pencil-alt',
				'text' => 'Edit',
				'link' => URL::createLink($moduleName, $controllerName, 'form', ['id' => $id])
			],

			'delete'        => [
				'class' => 'btn-danger btn-delete-item',
				'icon' => 'trash-alt', 'text' => 'Delete',
				'link' => URL::createLink($moduleName, $controllerName, 'delete', ['id' => $id])
			],

			'reset-password' => [
				'class' => 'btn-secondary',
				'icon' => 'key',
				'text' => 'Reset Password',
				'link' => URL::createLink($moduleName, $controllerName, 'resetPassword', ['id' => $id])
			]
		];

		$buttonInArea = [
			'default'  => ['edit', 'delete'],
			'group'    => ['edit', 'delete'],
			'category' => ['edit', 'delete'],
			'user'     => ['reset-password', 'edit', 'delete'],
			'cart'     => ['view'],
		];

		$controllerName = (array_key_exists($controllerName, $buttonInArea)) ? $controllerName : 'default';
		$listButton     = $buttonInArea[$controllerName];

		$xhtml = '';

		foreach ($listButton as $btn) {
			$currentButton = $templateButton[$btn];
			$xhtml .= sprintf('
			  <a href="%s" class="rounded-circle btn btn-sm %s" title="%s" data-toggle="tooltip">
				  <i class="fas fa-%s"></i>
			  </a>
			  ', $currentButton['link'], $currentButton['class'], $currentButton['text'], $currentButton['icon']);
		}

		return $xhtml;
	}
}
