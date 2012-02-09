<?php

class Application_Model_DbTable_Log extends Zend_Db_Table_Abstract
{

    protected $_name = 'log';
    protected $_referenceMap = array(
        'User' => array(
            'refTableClass' => 'Application_Model_DbTable_User',
            'refColumns' => 'id',
            'columns' => 'user_id'
        )
    );

}

