<?php

/**
 * @author Davi Alves
 */
class Application_Model_DbTable_Page extends Zend_Db_Table_Abstract
{

    /**
     * Table name
     *
     * @var string
     */
    protected $_name = 'page';
    protected $_dependentTables = array('Application_Model_DbTable_Log');

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->_name;
    }

}
