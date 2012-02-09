<?php

/**
 * @author Davi alves
 */
abstract class Application_Model_Base
{

    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable = null;

    /**
     * @param string $dbTable
     * @return Application_Model_Base
     * @throws Exception
     */
    protected function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    /**
     * @return Zend_Db_Table_Abstract
     */
    protected function getDbTable()
    {
        return $this->_dbTable;
    }

    /**
     * @param array $data 
     * @return int $id
     */
    protected function _insert(array $data)
    {
        $id = $this->getDbTable()->insert($data);
        $data += array('id' => $id);

        return $this->_internalLog('insert', $data);
    }

    /**
     *
     * @param array $data
     * @param string|array $where 
     */
    protected function _update(array $data, $where)
    {
        $this->_internalLog('update', $data);
        unset($data['id']);
        $this->getDbTable()->update($data, $where);
    }

    /**
     * @param type $data 
     */
    protected function _delete(array $data)
    {
        $where = array();
        foreach ($data as $key => $row) {
            $where["$key = ?"] = $row;
        }
        $this->_internalLog('delete', $data);
        $this->getDbTable()->delete($where);
    }

    /**
     * @param string $action
     * @param array $stuff
     */
    protected function _internalLog($action, $stuff)
    {
        $data = array();
        $table = $this->getDbTable();
        $user = Zend_Auth::getInstance()->getIdentity();
        $user_id = $user->id;
        $tableName = $table->getTableName();
        $last_value = null;
        $value = null;

        switch ($action) {
            case 'insert':
                $value = serialize($stuff);
                break;
            case 'update':
            case 'delete':
                $id = isset($stuff['id']) ? $stuff['id'] : 0;
                if ($id) {
                    $last_value = $this->_getChangedData($id);
                    $last_value = serialize($last_value);
                }
                if ($stuff) {
                    $value = serialize($stuff);
                }
                break;
        }

        $this->_saveLog($user_id, $tableName, $action, $last_value, $value);
    }

    /**
     * Persists log
     *
     * @param int $user_id
     * @param string $table
     * @param string $action
     * @param array $last_value
     * @param array $value
     */
    protected function _saveLog($user_id, $table, $action, $last_value, $value)
    {
        $date = new DateTime('now', new DateTimeZone('America/Fortaleza'));
        $data = array(
            'user_id' => $user_id,
            'table' => $table,
            'action' => $action,
            'last_value' => $last_value,
            'value' => $value,
            'date' => $date->format('Y-m-d H:i:s')
        );

        $log = new Application_Model_DbTable_Log();
        $log->insert($data);
    }

    /**
     * @param id $id
     * @return array
     */
    protected function _getChangedData($id)
    {
        $result = array();
        $table = $this->getDbTable();
        $data = $table->find((int) $id);
        if ($data) {
            $result = $data->current()->toArray();
        }

        return $result;
    }

    /**
     * @param string $date
     * @param boolean $toBr
     * @return string
     */
    protected function _formatDate($date, $toBr = false)
    {
        $dateTime = new DateTime($date, new DateTimeZone('America/Fortaleza'));
        if ($toBr) {
            $date = $dateTime->format('d-m-Y H:i');
        } else {
            $date = $dateTime->format('Y-m-d H:i:s');
        }

        return $date;
    }

    /**
     * @abstract
     * @param $id
     */
    abstract public function find($id);

    /**
     * @abstract
     */
    abstract public function findAll();

    /**
     * @param array $data
     */
    protected function _filterData(array $data)
    {
        
    }

}

