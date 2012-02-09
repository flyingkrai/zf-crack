<?php


/**
 * Description of Menu
 *
 * @author davi
 */
class Application_Model_Menu extends Application_Model_Base
{

    public function __construct()
    {
        $this->setDbTable('Application_Model_DbTable_Menu');
    }

    /**
     * @return integer
     */
    public function count()
    {
        $total = 0;
        try {
            $menu = $this->getDbTable();
            $select = $menu->select()
                ->from($menu, array(new Zend_Db_Expr('count(id) as total')));
            $result = $menu->fetchRow($select);
            if ($result) {
                $total = (int)$result->total;
            }
        } catch (Exception $ex) {

        }

        return (int)$total;
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
     * @return array
     */
    public function findAllOrdened()
    {
        $menu = $this->getDbTable();
        $select = $menu->select()->order('sequence');
        return $menu->fetchAll($select);
    }

    /**
     * @param array $data
     */
    public function save($data)
    {
        $data = $this->_filterData($data);

        if (isset($data['id']) && (int)$data['id']) {
            $this->getDbTable()->update($data, array('id = ?' => $data['id']));
        } else {
            $this->getDbTable()->insert($data);
        }
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        $this->getDbTable()->delete(array('id = ?' => $id));
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
                case 'page_id':
                case 'page':
                    $result['page_id'] = ($value) ? $value : null;
                    break;
                case 'title':
                    $result['title'] = $value;
                    break;
                case 'link':
                    $result['link'] = $value;
                    break;
                case 'target':
                    $result['target'] = $value;
                    break;
                case 'sequence':
                case 'order':
                    $result['sequence'] = (int)$value;
                    break;
            }
        }

        return $result;
    }

}
