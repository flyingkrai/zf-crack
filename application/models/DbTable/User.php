<?php

/**
 * @author Davi Alves
 */
class Application_Model_DbTable_User extends Zend_Db_Table_Abstract
{

    /**
     * Table name
     *
     * @var string
     */
    protected $_name = 'users';
    protected $_dependentTables = array('Application_Model_DbTable_Log');

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->_name;
    }

}
