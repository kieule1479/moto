<?php
class IndexModel extends Model
{

	//===== CONSTRUCT ======
	public function __construct()
	{
		parent::__construct();
		$this->setTable(TBL_moto);
	}

	//===== INFO ITEM ======
	public function infoItem($arrParam, $options = null)
	{

		if ($options['task'] == 'quick-view') {

			$id 	 = $arrParam['id'];
			$query[] = "SELECT `name`, `short_description`, `price`,`sale_off`, `picture`";
			$query[] = "FROM `$this->table`";
			$query[] = "WHERE `id` = '$id' ";
			$query  = implode(" ", $query);
			$result = $this->fetchRow($query);

			$salePrice       = ($result['price']  - ($result['price'] * $result['sale_off'] / 100));
			$salePriceFormat = number_format($salePrice) . ' đ';
			$priceFormat     = number_format($result['price']) . ' đ';
			return [
				'id'                => $id,
				'picture'           => $result['picture'],
				'name'              => $result['name'],
				'short_description' => $result['short_description'],
				'price'             => $result['price'],
				'salePrice'         => $salePrice,
				'salePriceFormat'   => $salePriceFormat,
				'priceFormat'       => $priceFormat,
			];
		}
	}


	//===== LIST ITEM ======
	public function listItem($params, $option = NULL)
	{

		$result = NULL;
		if ($option['task'] == 'sliders') {
			$query[]       = "SELECT `picture`";
			$query[]       = "FROM `" . TBL_SLIDER . "`";
			$query[]       = "WHERE `status` = 1";
			$query[]       = "ORDER BY `ordering` ASC";
		}

		if ($option['task'] == 'hotProducts') {
			$query[] = "SELECT `m`.`id`, `m`.`name`, `m`.`picture`, `m`.`price`, `m`.`sale_off`, `m`.`category_id`,AVG(`r`.`userReview`) AS `rating`";
			$query[] = "FROM `$this->table` AS `m` LEFT JOIN `rate` AS `r`";
			$query[] = "ON  `r`.`moto_id` =`m`.`id`";
			$query[] =  "WHERE `m`.`special` =1";
			$query[] = "GROUP BY `m`.`id`";


			// FILTER : KEYWORD
			if (!empty($arrParam['search'])) {
				$query[] = "AND (";
				$keyword = "'%{$arrParam['search']}%'";
				foreach ($this->fieldSearchAccepted as $field) {
					$query[] = "`$field` LIKE $keyword";
					$query[] = "OR";
				}
				array_pop($query);
				$query[] = ")";
			}
			// FILTER : STATUS
			if (isset($arrParam['status']) && $arrParam['status'] != 'all') {
				$query[] = "AND `status` = '{$arrParam['status']}'";
			}
		}

		if ($option['task'] == 'hotCategoryTitles') {
			$query[]       = "SELECT `id`, `name`,`special`";
			$query[]       = "FROM `" . TBL_CATEGORY . "`";
			$query[]       = "WHERE `special` = 1";
			$query[]       = "ORDER BY `id` ASC";
		}
		if ($option['task'] == 'specialCategoryList') {
			$query[] = "SELECT `id` ,`name`";
			$query[]	= "FROM `" . TBL_CATEGORY . "`";
			$query[]	= "WHERE `special` = 1";
		}


		if ($option['task'] == 'categoryInMotos') {
			$ids = "";
			$special = "SELECT `id`,`name` FROM `" . TBL_CATEGORY . "` WHERE `special` = 1";
			$special_id = $this->fetchAll($special);
			foreach ($special_id as $key => $value) {
				$ids .= ',' . $value['id'];
				$ids = ltrim($ids, ',');
			}
			$query[] = "SELECT `m`.`id` ,`m`.`name`,`m`.`picture`,`m`.`price`,`m`.`sale_off`,`m`.`special`,`m`.`category_id`, AVG(`r`.`userReview`) AS `rating` FROM `moto` AS `m` LEFT JOIN `rate` AS `r` ON `m`.`category_id` IN ($ids) AND (`r`.`moto_id`) = (`m`.id) GROUP BY `m`.`id` ";
		}

		if ($option['task'] == 'newMotoInfos') {
			$query[] = "SELECT `id` ,`title`,`short_description`,`link`,`picture`";
			$query[] = "FROM `news`";
			$query[] = "WHERE `status` = 1";
			$query[] = "ORDER BY `ordering` ASC";
		}
		if ($option['task'] == 'videos') {
			$query[] = "SELECT `id` ,`name`,`picture`";
			$query[] = "FROM `video`";
			$query[] = "WHERE `status` = 1";
			$query[] = "ORDER BY `id` DESC";
			$query[] = "LIMIT 0, 4";
		}

		if ($option['task'] == 'specialMoto') {
			$query[] = "SELECT `id` ,`name`,`picture`,`price`,`sale_off`,`special`";
			$query[]	= "FROM `$this->table`";
			$query[]	= "WHERE `special` = 1";
		}



		$query = implode(" ", $query);
		$result = $this->fetchAll($query);

		return $result;
	}
}
