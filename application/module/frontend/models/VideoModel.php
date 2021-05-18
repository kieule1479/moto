<?php
class VideoModel extends Model
{


	//===== CONSTRUCT ======
	public function __construct()
	{
		parent::__construct();
		$this->setTable(TBL_CATEGORY);
		$userObj 			= Session::get('user');
		$this->_userInfo 	= $userObj['info'];
	}

	//===== LIST ITEM ======
	public function listItem($arrParam, $option = null)
	{
		$result = NULL;
		if ($option['task'] == 'videos') {
			$query[] = "SELECT `id` ,`name`,`picture`";
			$query[] = "FROM `video`";
			$query[] = "WHERE `status` = 1";
			$query[] = "ORDER BY `id` DESC";
		}
		if ($option['task'] == 'videosRelate') {
			$id = $arrParam['video_id'];
			$query[] = "SELECT `id` ,`name`,`picture`";
			$query[] = "FROM `video`";
			$query[] = "WHERE `status` = 1";
			$query[] = "AND `id` != $id";
			$query[] = "ORDER BY `id` DESC";
		}

		if ($option['task'] == 'OneVideo') {
			$id = $arrParam['video_id'];
			$query[] = "SELECT `video`";
			$query[] = "FROM `video`";
			$query[] = "WHERE `id` = $id";
			$query[] = "ORDER BY `ordering` ASC";
		}

		if ($option['task'] == 'specialMoto1') {
			$query[] = "SELECT `m`.`id` ,`m`.`name`,`m`.`picture`,`m`.`price`,`m`.`sale_off`,`m`.`special`, AVG(`r`.`userReview`) AS `rating`";
			$query[] = "FROM `moto` AS `m` LEFT JOIN `rate` AS `r`";
			$query[] = "ON `m`.`id`= `r`.`moto_id` GROUP BY `m`.`id` HAVING `m`.`special` = 1 ";
			$query[] = "LIMIT 0,4";
		}
		if ($option['task'] == 'specialMoto2') {
			$query[] = "SELECT `m`.`id` ,`m`.`name`,`m`.`picture`,`m`.`price`,`m`.`sale_off`,`m`.`special`, AVG(`r`.`userReview`) AS `rating`";
			$query[] = "FROM `moto` AS `m` LEFT JOIN `rate` AS `r`";
			$query[] = "ON `m`.`id`= `r`.`moto_id` GROUP BY `m`.`id` HAVING `m`.`special` = 1 ";
			$query[] = "LIMIT 4,4";
		}

		if ($option['task'] == 'category') {

			$query[] = "SELECT `id` ,`name`";
			$query[] = "FROM `" . TBL_CATEGORY . "`";
			$query[] = "WHERE `status` = '1'";
			$query[] = "ORDER BY `ordering` ASC";
		}


		$query = implode(" ", $query);
		$result = $this->fetchAll($query);
		return $result;
	}
}
