<?php
class NewsModel extends Model
{
    private $_columns = ['id', 'title', 'picture', 'short_description', 'description', 'link',  'picture', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering'];
    private $fieldSearchAccepted = ['id', 'name'];
    private $_userInfo;

    //===== __CONSTRUCT ======
    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_NEWS);
        $userObj             = Session::get('user');
        $this->_userInfo     = $userObj['info'];
    }

    //===== COUNT ITEMS ======
    public function countItems($arrParam, $options = null)
    {

        //===== VARIABLE ======	
        $filter_search = $arrParam['filter_search'];

        $query[] = "SELECT COUNT(`id`) AS `total`";
        $query[] = "FROM `$this->table`";
        $query[] = "WHERE `id` > 0";

        if ($options == null) {
            //===== FILTER_SEARCH ======
            if (isset($arrParam['filter_search'])) {

                if ($arrParam['key'] == 'all') {
                    $query[]    = "AND (`name` LIKE \"%$filter_search%\" OR `id` LIKE \"%$filter_search%\") ";
                } else if ($arrParam['key'] == 'id') {
                    $query[]    = "AND `id` LIKE \"%$filter_search%\"  ";
                } else if ($arrParam['key'] == 'name') {
                    $query[]    = "AND  `name` LIKE \"%$filter_search%\"  ";
                }
            }
            // FILTER : STATUS
            if (isset($arrParam['status']) && $arrParam['status'] != 'all') {
                $query[] = "AND `status` = '{$arrParam['status']}'";
            }
        } else {
            if ($options['task'] == 'count-active') {
                $query[] = "AND `status` = 1";
            }
            if ($options['task'] == 'count-inactive') {
                $query[] = "AND `status` = 0";
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


        $query[] = "SELECT `id`, `title`,`description`, `short_description`,`link`, `picture`, `created`, `created_by`, `modified`, `modified_by`, `status`, `ordering`";
        $query[] = "FROM `$this->table`";
        $query[] = "WHERE `id` > 0";

        //===== FILTER_SEARCH ======
        if (isset($arrParam['filter_search'])) {

            if ($arrParam['key'] == 'all') {
                $query[]    = "AND (`name` LIKE \"%$filter_search%\" OR `id` LIKE \"%$filter_search%\") ";
            } else if ($arrParam['key'] == 'id') {
                $query[]    = "AND `id` LIKE \"%$filter_search%\"  ";
            } else if ($arrParam['key'] == 'name') {
                $query[]    = "AND  `name` LIKE \"%$filter_search%\"  ";
            }
        }
        //===== STATUS ======
        if ($arrParam['status'] == 'active') {
            $query[]    = "AND `status`= 1";
        }
        if ($arrParam['status'] == 'inactive') {
            $query[]    = "AND `status`= 0";
        }
        //===== FILTER_COLUMN ======
        if (!empty($arrParam['filter_column']) && !empty($arrParam['filter_column_dir'])) {
            $col        = $arrParam['filter_column'];
            $colDir     = $arrParam['filter_column_dir'];
            $query[]     = "ORDER BY `$col` $colDir";
        } else {
            $query[] = "ORDER BY `id` DESC";
        }

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
            $query[]    = "SELECT `title`, `short_description`,`description`,`link`, `status`, `ordering`, `picture`";
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

        if ($options['task'] == 'active') {
            $ids        = $arrParam['checkbox'];
            $ids        = implode(',', $ids);
            $ids        = "($ids)";
            $modifiedBy = 1;
            $modified   = date(DB_DATETIME_FORMAT, time());
            $query      = "UPDATE `$this->table` SET `status` = '1', `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` IN $ids";
            $this->query($query);
        }

        if ($options['task'] == 'inactive') {
            $ids        = $arrParam['checkbox'];
            $ids        = implode(',', $ids);
            $ids        = "($ids)";
            $modifiedBy = 1;
            $modified   = date(DB_DATETIME_FORMAT, time());
            $query      = "UPDATE `$this->table` SET `status` = '0', `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` IN $ids";
            $this->query($query);
        }

        if ($options['task'] == 'ajax_status') {
            $id         = $arrParam['id'];
            $status     = $arrParam['status'] == '1' ? '0' : '1';
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

        $result = $this->affectedRows();
        if ($result) {
            Session::set('notify', Helper::createNotify('success', 'update'));
        } else {
            Session::set('notify', Helper::createNotify('warning', 'updateError'));
        }
        return $result;
    }

    //===== AJAX ORDERING ======
    public function ajaxOrdering($params, $options = null)
    {
        $id         = $params['id'];
        $ordering   = $params['ordering'];
        $modifiedBy = $this->_userInfo['username'];
        $modified   = date(DB_DATETIME_FORMAT, time());
        $query      = "UPDATE `$this->table` SET `ordering` = $ordering, `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` = $id";
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

        $idss = $this->createWhereDeleteSQL($ids);

        $query  = "SELECT `id`, `picture` AS `name` FROM `$this->table` WHERE `id` IN($idss)";
        $arrImg = $this->fetchPairs($query);

        require_once PATH_LIBRARY_EXT . 'Upload.php';
        $uploadObj = new Upload();
        foreach ($arrImg as $val) {
            $uploadObj->removeFile('news', $val);
            $uploadObj->removeFile('news', '220x147-' . $val);
        }

        $result = $this->delete($ids);

        if ($result) {
            Session::set('notify', Helper::createNotify('success', 'deleteSuccess'));
        } else {
            Session::set('notify', Helper::createNotify('warning', 'deleteError'));
        }
    }

    //===== SAVE ITEM ======
    public function saveItem($params, $options = [])
    {

        if ($options['task'] == 'add') {

            require_once PATH_LIBRARY_EXT . 'Upload.php';
            $uploadObj = new Upload();

            $params['form']['picture']    = $uploadObj->uploadFile($params['form']['picture'], 'news');
            $params['form']['created']    = date(DB_DATETIME_FORMAT);
            $params['form']['created_by'] = $this->_userInfo['username'];

            $data   = array_intersect_key($params['form'], array_flip($this->_columns));


            $result = $this->insert($data);

            if ($result) {
                Session::set('notify', Helper::createNotify('success', 'addDataSuccess'));
            } else {
                Session::set('notify', Helper::createNotify('warning', 'addDataError'));
            }
            return $result;
        }

        if ($options['task'] == 'edit') {

           
            require_once PATH_LIBRARY_EXT . 'Upload.php';
            $uploadObj = new Upload();

            $params['form']['picture']     = $uploadObj->uploadFile($params['form']['picture'], 'news');
            $params['form']['modified']    = date(DB_DATETIME_FORMAT);
            $params['form']['modified_by'] = $this->_userInfo['username'];

            if ($params['form']['picture'] == null) {
                unset($params['form']['picture']);
            } else {

                
                // xoa trong thu muc
                $id = $params['id'];
                $query     = "SELECT `picture` FROM `$this->table` WHERE `id` = $id";
                $name      = $this->fetchRow($query)['picture'];
 
                $uploadObj->removeFile('news', $name);
                $uploadObj->removeFile('news', '220x147-' . $name);
            }

            $data   = array_intersect_key($params['form'], array_flip($this->_columns));
            

            $result = $this->update($data, [['id', $params['id']]]);
            if ($result) {
                Session::set('notify', Helper::createNotify('success', 'update'));
            } else {
                Session::set('notify', Helper::createNotify('warning', 'updateError'));
            }
            return $params['id'];
        }
    }
}
