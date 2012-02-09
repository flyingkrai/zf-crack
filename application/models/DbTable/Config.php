<?php

class Application_Model_DbTable_Config extends Zend_Db_Table_Abstract
{

    protected $_name = 'config';

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->_name;
    }


}

