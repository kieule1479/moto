<?php
class MotoModel extends Model
{
    private $_columns = ['id', 'name', 'short_description', 'description', 'price', 'picture', 'sale_off', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'category_id', 'special', 'gallery'];
    private $fieldSearchAccepted = ['id', 'name'];
    private $_userInfo;

    //===== __CONSTRUCT ======
    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_moto);

        $userObj             = Session::get('user');
        $this->_userInfo     = $userObj['info'];
    }

    //===== ITEM INSELECT BOX ======
    public function itemInSelectBox($params, $options = null)
    {
        $query  = "SELECT `id`, `name` FROM `" . TBL_CATEGORY . "`";
        $result = $this->fetchPairs($query);
        if ($options == 'add-default') {
            $result = ['default' => '- Select Category -'] + $result;
        }
        return $result;
    }

    //===== COUNT ITEMS ======
    public function countItems($arrParam, $options = null)
    {
        $query[] = "SELECT COUNT(`id`) AS `total`";
        $query[] = "FROM `$this->table`";
        $query[] = "WHERE `id` > 0";

        if ($options == null) {
            //===== STATUS ======
            if ($arrParam['status'] == 'active') {
                $query[]    = "AND `status`= 1";
            }
            if ($arrParam['status'] == 'inactive') {
                $query[]    = "AND `status`= 0";
            }
        }

        if ($options['task'] == 'count-active') {
            $query[] = "AND `status` = '1'";
        }

        if ($options['task'] == 'count-inactive') {
            $query[] = "AND `status` = '0'";
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

        if (isset($arrParam['filter_category_id']) && $arrParam['filter_category_id'] != 'default') {
            $query[] = "AND `category_id` = {$arrParam['filter_category_id']}";
        }

        $query = implode(' ', $query);
        $result = $this->fetchRow($query)['total'];

        return $result;
    }

    //===== LIST ITEMS ======
    public function listItems($arrParam, $options = null)
    {

        //===== VARIABLE ======	
        $filter_search = $arrParam['filter_search'];

        $query[] = "SELECT `b`.`id`, `b`.`name`,`b`.`picture`,`b`.`special`,`b`.`price`,`b`.`sale_off`,`b`.`ordering`, `b`.`created`, `b`.`created_by`, `b`.`status`, `b`.`category_id`";
        $query[] = "FROM `$this->table` AS `b` LEFT JOIN `" . TBL_CATEGORY . "`AS `c` ON `b`.`category_id`= `c`.`id`";
        $query[] = "WHERE `b`.`id` > 0";

        //===== FILTER_SEARCH ======
        if (isset($arrParam['filter_search'])) {
            if ($arrParam['key'] == 'all') {
                $query[]    = "AND (`b`.`name` LIKE \"%$filter_search%\" OR `b`.`id` LIKE \"%$filter_search%\") ";
            } else if ($arrParam['key'] == 'id') {
                $query[]    = "AND `b`.`id` LIKE \"%$filter_search%\"  ";
            } else if ($arrParam['key'] == 'name') {
                $query[]    = "AND `b`. `name` LIKE \"%$filter_search%\"  ";
            }
        }

        // FILTER : CATEGORY
        if (isset($arrParam['filter_category_id']) && $arrParam['filter_category_id'] != 'default') {
            $query[] = "AND `b`.`category_id` = {$arrParam['filter_category_id']}";
        }

        // FILTER : STATUS
        if (isset($arrParam['status']) && $arrParam['status'] != 'all') {
            //===== STATUS ======
            if ($arrParam['status'] == 'active') {
                $query[]    = "AND `b`.`status`= 1";
            }
            if ($arrParam['status'] == 'inactive') {
                $query[]    = "AND `b`.`status`= 0";
            }
        }

        $query[]    = "ORDER BY `id` DESC";

        $pagination         = $arrParam['pagination'];
        $totalItemsPerPage  = $pagination['totalItemsPerPage'];
        if ($totalItemsPerPage > 0) {
            $position   = ($pagination['currentPage'] - 1) * $totalItemsPerPage;
            $query[]    = "LIMIT $position, $totalItemsPerPage";
        }
        $query  = implode(" ", $query);

        $result = $this->fetchAll($query);
        return $result;
    }

    //===== INFO ITEM ======
    public function infoItem($arrParam, $option = null)
    {
        if ($option == null) {
            $query[]    = "SELECT `name`,`picture`,`gallery`, `description`,`short_description`,`sale_off`, `price`, `special`, `status`, `category_id`";
            $query[]    = "FROM `$this->table`";
            $query[]    = "WHERE `id` = '" . $arrParam['id'] . "'";
            $query      = implode(" ", $query);
            $result     = $this->fetchRow($query);
            return $result;
        }
    }

    //===== CHANGE STATUS ======
    public function changeStatus($arrParam, $options = null)
    {
        if ($options == null) {
            $modifiedBy = $this->_userInfo;
            $modified   = date(DB_DATETIME_FORMAT, time());
            $status = $arrParam['status'] == '1' ? '1' : '0';
            $query  = "UPDATE `$this->table` SET `status` = '$status', `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` = {$arrParam['id']}";
            $this->query($query);
        }

        if ($options['task'] == 'active') {

            $ids        = $arrParam['checkbox'];
            $ids        = implode(',', $ids);
            $ids        = "($ids)";
            $modifiedBy = $this->_userInfo['username'];
            $modified   = date(DB_DATETIME_FORMAT, time());
            $query      = "UPDATE `$this->table` SET `status` = 'active', `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` IN $ids";
            $this->query($query);
        }

        if ($options['task'] == 'inactive') {

            $ids        = $arrParam['checkbox'];
            $ids        = implode(',', $ids);
            $ids        = "($ids)";
            $modifiedBy = $this->_userInfo['username'];
            $modified   = date(DB_DATETIME_FORMAT, time());
            echo  $query      = "UPDATE `$this->table` SET `status` = 0, `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` IN $ids";

            $this->query($query);
        }
        if ($options['task'] == 'ajax_status') {


            $id         = $arrParam['id'];
            $status     = $arrParam['status'] == 1 ? 0 : 1;
            $modifiedBy = $this->_userInfo['username'];
            $modified   = date(DB_DATETIME_FORMAT, time());
            $query      = "UPDATE `$this->table` SET `status` = '$status', `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` = $id";
            $this->query($query);
            return [
                'id'       => $id,
                'status'   => $status,
                'modified' => Helper::showItemHistory($modifiedBy, $modified),
                'link'     => URL::createLink($arrParam['module'], $arrParam['controller'], 'ajaxStatus', ['id' => $id, 'status' => $status]),
            ];
        }
        if ($options['task'] == 'ajax_special') {

            $id         = $arrParam['id'];
            $special    = $arrParam['special'] == 1 ? 0 : 1;
            $modifiedBy = $this->_userInfo['username'];
            $modified   = date(DB_DATETIME_FORMAT, time());
            $query      = "UPDATE `$this->table` SET `special` = '$special', `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` = $id";
            $this->query($query);
            return [
                'id'       => $id,
                'special'   => $special,
                'modified' => Helper::showItemHistory($modifiedBy, $modified),
                'link'     => URL::createLink($arrParam['module'], $arrParam['controller'], 'ajaxSpecial', ['id' => $id, 'special' => $special]),
            ];
        }

        if ($options['task'] == 'change-group-acp') {
            $id         = $arrParam['id'];
            $groupACP   = $arrParam['group_acp'] == 0 ? 1 : 0;
            $modifiedBy = $this->_userInfo['username'];
            $modified   = date(DB_DATETIME_FORMAT, time());
            $query = "UPDATE `$this->table` SET `group_acp` = $groupACP, `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` = $id";
            $this->query($query);

            return [
                'id'        => $id,
                'state'     => $groupACP,
                'modified'  => Helper::showItemHistory($modifiedBy, $modified),
                'link'      => URL::createLink($arrParam['module'], $arrParam['controller'], 'changeGroupACP', ['id' => $id, 'group_acp' => $groupACP])
            ];
        }

        echo $result = $this->affectedRows();
        if ($result) {
            Session::set('notify', Helper::createNotify('success', 'update'));
        } else {
            Session::set('notify', Helper::createNotify('warning', 'updateError'));
        }
        return $result;
    }

    //===== CHANGE CATEGORY ======
    public function changeCategory($params, $options = null)
    {
        $id         = $params['id'];
        $categoryId = $params['category_id'];
        $modifiedBy = $this->_userInfo['username'];
        $modified   = date(DB_DATETIME_FORMAT, time());
        $query      = "UPDATE `$this->table` SET `category_id` = $categoryId, `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` = $id";
        $this->query($query);
        return [
            'id' => $id,
            'modified'  => Helper::showItemHistory($modifiedBy, $modified),
        ];
    }

    //===== DELETE ITEMS ======
    public function deleteItems($arrParam, $options = [])
    {
        $ids = [];
        if (isset($arrParam['id'])) $ids = [$arrParam['id']];
        if (isset($arrParam['checkbox'])) $ids = $arrParam['checkbox'];

        $result = $this->delete($ids);

        if ($result) {
            Session::set('notify', Helper::createNotify('success', SUCCESS_DELETE));
        } else {
            Session::set('notify', Helper::createNotify('warning', FAIL_ACTION));
        }

        if ($result) {
            Session::set('notify', Helper::createNotify('success', 'deleteSuccess'));
        } else {
            Session::set('notify', Helper::createNotify('warning', 'deleteError'));
        }
        return $result;
    }

    //===== SAVE ITEM ======
    public function saveItem($params, $options = [])
    {


        require_once PATH_LIBRARY_EXT . 'Upload.php';
        $uploadObj = new Upload();

        if ($options['task'] == 'add') {
            $params['form']['name']              = $params['form']['name'];                                     //@mysqli_real_escape_string($link, $params['form']['name']); // KO BI LOI DAU '
            $params['form']['short_description'] = $params['form']['short_description'];                        //@mysqli_real_escape_string($link, $params['form']['short_description']);
            $params['form']['description']       = $params['form']['description'];                              //@mysqli_real_escape_string($link, $params['form']['description']);
            $params['form']['price']             = $params['form']['price'];
            $params['form']['sale_off']          = $params['form']['sale_off'];
            $params['form']['status']            = $params['form']['status'];
            $params['form']['special']           = $params['form']['special'];
            $params['form']['created']           = date(DB_DATETIME_FORMAT);
            $params['form']['created_by']        = $this->_userInfo['username'];
            $params['form']['picture']           = $uploadObj->uploadFile($params['form']['picture'], 'moto');
            $params['form']['gallery']           = json_encode(array_values($uploadObj->uploadFile($params['form']['gallery'], 'gallery', 115, 75, 'multi')));

            $params['form']['category_id']       = $params['form']['category_id'];
            $data                                = array_intersect_key($params['form'], array_flip($this->_columns));
            $result                              = $this->insert($data);

            if ($result) {
                Session::set('notify', Helper::createNotify('success', 'addDataSuccess'));
            } else {
                Session::set('notify', Helper::createNotify('warning', 'addDataError'));
            }
            return $result;
        }

        if ($options['task'] == 'edit') {

            $params['form']['name']              = $params['form']['name'];
            $params['form']['short_description'] = $params['form']['short_description'];
            $params['form']['description']       = $params['form']['description'];
            $params['form']['price']             = $params['form']['price'];
            $params['form']['sale_off']          = $params['form']['sale_off'];
            $params['form']['special']           = $params['form']['special'];
            $params['form']['created']           = date(DB_DATETIME_FORMAT);
            $params['form']['created_by']        = $this->_userInfo['username'];
            $params['form']['status']            = $params['form']['status'];
            $params['form']['picture']           = $uploadObj->uploadFile($params['form']['picture'], 'moto');
            $params['form']['gallery']           = json_encode(array_values($uploadObj->uploadFile($params['form']['gallery'], 'gallery', 115, 75, 'multi')));



            if ($params['form']['picture'] == null) {
                unset($params['form']['picture']);
            } else {
                // xoa trong thu muc

                $id        = $params['id'];
                $query     = "SELECT `picture` FROM `$this->table` WHERE `id` = $id";

                $name      = $this->fetchRow($query)['picture'];
                $uploadObj->removeFile('moto', $name);
                $uploadObj->removeFile('moto', '220x147-' . $name);
            }

            $arr = json_decode($params['form']['gallery']);
            if (empty($arr)) {
                unset($params['form']['gallery']);
            } else {

                // xoa trong thu muc
                $id        = $params['id'];
                $query     = "SELECT `gallery` FROM `$this->table` WHERE `id` = $id";

                $name      = $this->fetchRow($query)['gallery'];
                $name = json_decode($name);

                foreach ($name as $key => $value) {
                    $uploadObj->removeFile('gallery', $value);
                    $uploadObj->removeFile('gallery', '115x75-' . $value);
                }
            }


            $data                                = array_intersect_key($params['form'], array_flip($this->_columns));
            $result                              = $this->update($data, [['id', $params['id']]]);
            if ($result) {
                Session::set('notify', Helper::createNotify('success', 'editDataSuccess'));
            } else {
                Session::set('notify', Helper::createNotify('warning', 'editDataError'));
            }
            return $params['id'];
        }
    }

    //===== AJAX ORDERING ======
    public function ajaxOrdering($params, $options = [])
    {
        $id = $params['id'];
        $ordering = $params['ordering'];
        $modifiedBy = $this->_userInfo['username'];
        $modified   = date(DB_DATETIME_FORMAT, time());
        $query = "UPDATE `$this->table` SET `ordering` = $ordering, `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` = $id";
        $this->query($query);
        return [
            'id' => $id,
            'modified'  => Helper::showItemHistory($modifiedBy, $modified),
        ];
    }
}
