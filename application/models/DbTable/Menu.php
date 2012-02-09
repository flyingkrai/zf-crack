<?php

/**
 * @author Davi Alves
 */
class Application_Model_DbTable_Menu extends Zend_Db_Table_Abstract
{

    /**
     * Table name
     *
     * @var string
     */
    protected $_name = 'menu';
    protected $_referenceMap = array(
        'Page' => array(
            'refTableClass' => 'Application_Model_DbTable_Page',
            'refColumns' => 'id',
            'columns' => 'page_id'
        )
    );

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->_name;
    }

}
