<?php

class Application_Model_Log extends Application_Model_Base
{

    public function __construct()
    {
        $this->setDbTable('Application_Model_DbTable_Log');
    }

    public function count($action = null, $table = null)
    {
        $total = 0;
        try {
            $menu = $this->getDbTable();
            $select = $menu->select()
                    ->from($menu, array(new Zend_Db_Expr('count(id) as total')));

            if ($action) {
                $select->where('action = ?', $action);
            }
            if ($table) {
                $select->where('log.table = ?', $table);
            }

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
        return $this->getDbTable()->fetchAll(null, 'date DESC');
    }

    public function publicLog($entity, $action, $last_value, $value)
    {
        $user_id = Zend_Auth::getInstance()->getIdentity()->id;
        parent::_saveLog($user_id, $entity, $action, $last_value, $value);
    }

}

