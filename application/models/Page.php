<?php

/**
 * Description of Page
 *
 * @author davi
 */
class Application_Model_Page extends Application_Model_Base implements Application_Model_BaseInteface
{

    public function __construct()
    {
        $this->setDbTable('Application_Model_DbTable_Page');
    }

    /**
     * @return integer
     */
    public function count()
    {
        $total = 0;
        try {
            $page = $this->getDbTable();
            $select = $page->select()
                    ->from($page, array(new Zend_Db_Expr('count(id) as total')));
            $result = $page->fetchRow($select);
            if ($result) {
                $total = (int) $result->total;
            }
        } catch (Exception $ex) {
            
        }

        return (int) $total;
    }

    /**
     * @param int $id
     * @return Zend_Db_Table_Row|null
     */
    public function find($id)
    {
        $result = $this->getDbTable()->find($id);
        if ($result) {
            $result = $result->current();
        }

        return $result;
    }

    /**
     * @return Zend_Db_Table_Rowset
     */
    public function findAll()
    {
        return $this->getDbTable()->fetchAll();
    }

    /**
     * @param array $data
     * @return int $id
     */
    public function save($data)
    {
        $data = $this->_filterData($data);
        $zDate = new Zend_Date();
        $now = $zDate->toString('yyyy-MM-dd H:m:s', null, new Zend_Locale('America/Fortaleza'));

        if (isset($data['id']) && (int) $data['id']) {
            $data['updated'] = $now;
            $id = $data['id'];
            parent::_update($data, array('id = ?' => $data['id']));
        } else {
            $data['created'] = $now;
            $id = parent::_insert($data);
        }

        return (int) $id;
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        parent::_delete(array('id' => $id));
    }

    /**
     * @param array $data
     * @return array
     */
    protected function _filterData(array $data)
    {
        $result = array();

        foreach ($data as $row => $value) {
            switch (strtolower($row)) {
                case 'id':
                    $result['id'] = $value;
                    break;
                case 'title':
                    $result['title'] = $value;
                    break;
                case 'url':
                    $result['url'] = $value;
                    break;
                case 'content':
                case 'text':
                    $result['content'] = $value;
                    break;
                case 'created':
                    $result['created'] = $value;
                    break;
                case 'updated':
                    $result['updated'] = $value;
                    break;
            }
        }

        return $result;
    }

    public function log($action, $stuff)
    {
        ;
    }

}
