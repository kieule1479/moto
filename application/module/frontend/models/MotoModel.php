<?php
class MotoModel extends Model
{

	private $_columns = array('id', 'name', 'description', 'price', 'sale_off', 'picture', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'category_id');
	private $_userInfo;

	//===== CONSTRUCT ======
	public function __construct()
	{
		parent::__construct();
		$this->setTable(TBL_moto);
		$userObj 			= Session::get('user');
		$this->_userInfo 	= $userObj['info'];
	}

	//===== LIST ITEM ======
	public function listItem($params, $option = NULL)
	{

		$result = NULL;
		$valueSearch = $params['search_moto'];

		if ($option['task'] == 'relateMoto') {
			$id          = $params['moto_id'];
			$queryID     = "SELECT `category_id` FROM `$this->table` WHERE `id` = '$id'";
			$category_id = $this->fetchRow($queryID);
			$category_id = $category_id['category_id'];

			$query[] = "SELECT `m`.`id` ,`m`.`name`,`m`.`picture`,`m`.`price`,`m`.`sale_off`,`m`.`special`, `r`.`moto_id`";
			$query[] = "FROM `$this->table` AS `m` LEFT JOIN `rate` AS `r`";
			$query[] = "ON `m`.`category_id` = '$category_id' AND `m`.`id`!='$id' AND `m`.`id` =`r`.`moto_id`";
		}
		if ($option['task'] == 'newMoto1') {
			$query[] = "SELECT `m`.`id` ,`m`.`name`,`m`.`picture`,`m`.`price`,`m`.`sale_off`,`m`.`special`, AVG(`r`.`userReview`) AS `rating`";
			$query[] = "FROM `$this->table` AS `m` LEFT JOIN `rate` AS `r`";
			$query[] = "ON `m`.`id`= `r`.`moto_id` GROUP BY `m`.`id`";
			$query[] = "ORDER BY `created` DESC";
			$query[] = "LIMIT 0,4";
		}
		if ($option['task'] == 'newMoto2') {
			$query[] = "SELECT `id` ,`name`,`picture`,`price`,`sale_off`,`special`";
			$query[] = "FROM `$this->table`";
			$query[] = "ORDER BY `created` DESC";
			$query[] = "LIMIT 4,4";
		}
		if ($option['task'] == 'specialMoto1') {
			$query[] = "SELECT `m`.`id` ,`m`.`name`,`m`.`picture`,`m`.`price`,`m`.`sale_off`,`m`.`special`, AVG(`r`.`userReview`) AS `rating`";
			$query[] = "FROM `$this->table` AS `m` LEFT JOIN `rate` AS `r`";
			$query[] = "ON `m`.`id`= `r`.`moto_id` GROUP BY `m`.`id` HAVING `m`.`special` = 1 ";
			$query[] = "LIMIT 0,4";
		}
		if ($option['task'] == 'specialMoto2') {
			$query[] = "SELECT `m`.`id` ,`m`.`name`,`m`.`picture`,`m`.`price`,`m`.`sale_off`,`m`.`special`, AVG(`r`.`userReview`) AS `rating`";
			$query[] = "FROM `$this->table` AS `m` LEFT JOIN `rate` AS `r`";
			$query[] = "ON `m`.`id`= `r`.`moto_id` GROUP BY `m`.`id` HAVING `m`.`special` = 1 ";
			$query[] = "LIMIT 4,4";
		}
		if ($option['task'] == 'motoInCategory') {


			$idCat   = $params['category_id'];
			$query[] = "SELECT `m`.`id` ,`m`.`name`,`m`.`picture`,`m`.`price`,`m`.`sale_off`,`m`.`special`,`m`.`category_id`,`m`.`status`, AVG(`r`.`userReview`) AS `rating`";
			$query[] = "FROM `$this->table` AS `m` LEFT JOIN `rate` AS `r`";
			$query[] = "ON `m`.`id`= `r`.`moto_id`";
			$query[] = "WHERE `m`.`category_id` = '$idCat'";
			$query[] = "GROUP BY `m`.`id` HAVING `m`.`status` = 1";


			if ($params['sort'] == 'price_asc') {
				$query[] = "ORDER BY (`price`*(100 -`sale_off`)) ASC";
			}
			if ($params['sort'] == 'price_desc') {
				$query[] = "ORDER BY (`price`*(100 -`sale_off`)) DESC";
			}
			if ($params['sort'] == 'latest') {
				$query[] = "ORDER BY `created` DESC";
			}

			$pagination        = $params['pagination'];
			$totalItemsPerPage = $pagination['totalItemsPerPage'];
			if ($totalItemsPerPage > 0) {
				$position   = ($pagination['currentPage'] - 1) * $totalItemsPerPage;
				$query[]    = "LIMIT $position, $totalItemsPerPage";
			}
		}
		if ($option['task'] == 'categoryList') {

			$query[] = "SELECT `id` ,`name`";
			$query[] = "FROM `" . TBL_CATEGORY . "`";
			$query[] = "WHERE `status` = '1'";
			$query[] = "ORDER BY `ordering` ASC";
		}
		if ($option['task'] == NULL) {

			$query[] = "SELECT `m`.`id` ,`m`.`name`,`m`.`picture`,`m`.`price`,`m`.`sale_off`,`m`.`special`,`m`.`category_id`,`m`.`status`, AVG(`r`.`userReview`) AS `rating`";
			$query[] = "FROM `$this->table`AS `m` LEFT JOIN `rate` AS `r`";
			$query[] = "ON `m`.`id`= `r`.`moto_id`";

			if (isset($params['search_moto'])) {

				$query[] = "WHERE  `m`.`name` LIKE '%$valueSearch%'";
			}
			$query[] = "GROUP BY `m`.`id` HAVING `m`.`status` = 1";

			if ($params['sort'] == 'price_asc') {
				$query[] = "ORDER BY (`price`*(100 -`sale_off`)) ASC";
				
			}
			if ($params['sort'] == 'price_desc') {
				$query[] = "ORDER BY (`price`*(100 -`sale_off`)) DESC";
			}
			if ($params['sort'] == 'latest') {
				$query[] = "ORDER BY `created` DESC";
			}




			$pagination        = $params['pagination'];
			$totalItemsPerPage = $pagination['totalItemsPerPage'];
			if ($totalItemsPerPage > 0) {
				$position   = ($pagination['currentPage'] - 1) * $totalItemsPerPage;
				$query[]    = "LIMIT $position, $totalItemsPerPage";
			}
		}

		if ($option['task'] == 'infoMoto') {
			$idMoto = $params['moto_id'];
			$query[]    = "SELECT `id` ,`name`,`picture`,`price`,`sale_off`,`special`,`category_id`,`sort_description`,`description`";
			$query[]	= "FROM `$this->table`";
			$query[]	= "WHERE `id` = '$idMoto'";
		}
		 $query = implode(" ", $query);

		$result = $this->fetchAll($query);
		return $result;
	}

	//===== COUNT ITEMS ======
	public function countItems($arrParam, $options = null)
	{
		$query[] = "SELECT COUNT(`id`) AS `total`";
		$query[] = "FROM `$this->table`";
		$query[] = "WHERE `id` > 0";
		if ($options == null) {

			if (isset($arrParam['category_id'])) {
				$category_id = $arrParam['category_id'];
				$query[] = "AND `category_id` = '$category_id'";
			}
			if (isset($arrParam['search_moto'])) {
				$key = $arrParam['search_moto'];
				$query[] = "AND  `name` LIKE '%$key%'";
			}
		}

		// FILTER : KEYWORD
		if (!empty($arrParam['search'])) {
			$query[] = "AND (";
			$keyword    = "'%{$arrParam['search']}%'";
			foreach ($this->fieldSearchAccepted as $field) {
				$query[] = "`$field` LIKE $keyword";
				$query[] = "OR";
			}
			array_pop($query);
			$query[] = ")";
		}
		$query = implode(' ', $query);
		$result = $this->fetchRow($query)['total'];
		return $result;
	}

	//===== INFO ITEM ======
	public function infoItem($arrParam, $option = null)
	{
		if ($option == null) {
			$idMoto = $arrParam['moto_id'];
			$query[]    = "SELECT `id` ,`name`,`gallery`,`picture`,`price`,`sale_off`,`special`,`category_id`,`short_description`,`description`";
			$query[]	= "FROM `$this->table`";
			$query[]	= "WHERE `id` = '$idMoto'";
			$query		= implode(" ", $query);

			$result		= $this->fetchRow($query);
			return $result;
		}
	}

	//===== GET ID moto ======
	public function getIDmoto($arrParam)
	{
		$flag  		   = false;
		$idMoto 	   = $arrParam['moto_id'];
		$query[]       = "SELECT `id`";
		$query[]       = "FROM `$this->table`";
		$query[]       = "WHERE `id` >0";
		$query  	   = implode(" ", $query);
		$result		   = $this->fetchAll($query);
		foreach ($result as $key => $value) {
			if ($value['id'] == $idMoto) {
				$flag = true;
				break;
			} else {
				$flag = false;
			}
		}
		return $flag;
	}
}
