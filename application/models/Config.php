<?php

class Application_Model_Config
{

    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable = null;

    /**
     * @param string $dbTable
     * @return Application_Model_Config
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

    public function __construct()
    {
        $this->setDbTable('Application_Model_DbTable_Config');
    }

    public function find($type, $key)
    {
        $table = $this->getDbTable();
        $select = $table->select()
            ->where('type = ?', $type)
            ->where('name = ?', $key);

        return $table->fetchRow($select);
    }

    public function save($type, $data)
    {
        $table = $this->getDbTable();
        $data = $this->_filterData($type, $data);
        foreach ($data as $name => $value) {
            $where = array(
                'type = ?' => $type,
                'name = ?' => $name
            );
            $table->update(array('value' => $value), $where);
        }
    }

    public function findAll($type)
    {
        $result = new stdClass();

        $table = $this->getDbTable();
        $select = $table->select()
            ->where('type = ?', $type);


        $data = $table->fetchAll($select);
        if ($data) {
            foreach ($data as $row) {
                $result->{$row->name} = $row->value;
            }
        }

        return $result;
    }

    /**
     * @param string $type
     * @param array $data
     * @return array
     */
    protected function _filterData($type, $data)
    {
        $result = array();

        switch ($type) {
            case 'opengraph':
                $result = $this->_filterOpenGraph($data);
                break;
        }

        return $result;
    }

    /**
     * @param array $data
     * @return array
     */
    protected function _filterOpenGraph($data)
    {
        $result = array();

        foreach ($data as $key => $value) {
            switch ($key) {
                case 'title':
                    $result['title'] = $value;
                    break;
                case 'type':
                    $result['type'] = $value;
                    break;
                case 'url':
                    $result['url'] = $value;
                    break;
                case 'image':
                    $result['image'] = $value;
                    break;
                case 'siteName':
                    $result['siteName'] = $value;
                    break;
                case 'description':
                    $result['description'] = $value;
                    break;
            }
        }

        return $result;
    }

}

