<?php

/**
 * Description of User
 *
 * @author davi
 */
class Application_Model_User extends Application_Model_Base implements Application_Model_BaseInteface
{

    public function __construct()
    {
        $this->setDbTable('Application_Model_DbTable_User');
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

        if (isset($data['id']) && (int) $data['id']) {
            $id = $data['id'];
            unset($data['username']);
            parent::_update($data, array('id = ?' => $data['id']));
        } else {
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

    protected function _hashPass($salt, $pass)
    {
        return sha1($pass . $salt);
    }

    protected function _generateSalt()
    {
        return sha1(rand(100000, 999999));
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
                case 'name':
                    $result['name'] = $value;
                    break;
                case 'role':
                    $result['role'] = $value;
                    break;
                case 'username':
                    $result['username'] = $value;
                    break;
                case 'email':
                    $result['email'] = $value;
                    break;
                case 'password':
                    if ($value) {
                        $result['salt'] = $this->_generateSalt();
                        $result['password'] = $this->_hashPass($result['salt'], $value);
                    }
                    break;
            }
        }

        return $result;
    }

}
