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
     * @abstract
     */
    abstract public function count();

    /**
     * @abstract
     * @param array $data
     */
    abstract public function save($data);

    /**
     * @param int $id
     */
    abstract public function delete($id);

    /**
     * @abstract
     * @param array $data
     */
    abstract protected function _filterData(array $data);
}
