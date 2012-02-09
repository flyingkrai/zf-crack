<?php

/**
 * @author Davi Alves
 */
class Application_Model_DbTable_Timeline extends Zend_Db_Table_Abstract
{
    /**
     * Table name
     *
     * @var string
     */
    protected $_name = 'timeline';

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->_name;
    }
}
