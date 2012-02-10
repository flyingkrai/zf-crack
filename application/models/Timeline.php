<?php

/**
 * Description of Timeline
 *
 * @author davi
 */
class Application_Model_Timeline extends Application_Model_Base implements Application_Model_BaseInteface
{

    public function __construct()
    {
        $this->setDbTable('Application_Model_DbTable_Timeline');
    }

    /**
     * @return integer
     */
    public function count()
    {
        $total = 0;
        try {
            $timeline = $this->getDbTable();
            $select = $timeline->select()
                    ->from($timeline, array(new Zend_Db_Expr('count(id) as total')));
            $result = $timeline->fetchRow($select);
            if ($result) {
                $total = (int) $result->total;
            }
        } catch (Exception $ex) {
            
        }

        return (int) $total;
    }

    /**
     * @param array $data
     * @return int $id
     */
    public function save($data)
    {
        $data = $this->_filterData($data);

        if (isset($data['id']) && (int) $data['id']) {
            $id = $data['id'];
            parent::_update($data, array('id = ?' => $data['id']));
        } else {
            $id = $this->getDbTable()->insert($data);
        }

        return (int) $id;
    }

    /**
     * @param integer $id
     */
    public function delete($id)
    {
        parent::_delete(array('id' => $id));
    }

    /**
     * @param integer $id
     */
    public function deleteImage($id)
    {
        $timeline = $this->find($id);
        $timeline->image = '';
        $this->save($timeline->toArray());
    }

    /**
     * @param integer $id
     * @return Zend_Db_Table_Row|null
     */
    public function find($id)
    {
        $result = $this->getDbTable()->find($id);
        if ($result) {
            $result = $result->current();
            $result->date = $this->_formatDate($result->date, true);
        }

        return $result;
    }

    /**
     * @return Zend_Db_Table_Rowset
     */
    public function findAll()
    {
        return $this->getDbTable()->fetchAll();
    }

    /**
     * @return array
     */
    public function getFormatedTimeline()
    {
        $formated = array();
        $table = $this->getDbTable();
        $select = $table->select()->order('date DESC');
        $timelines = $table->fetchAll($select);
        if ($timelines->count() > 0) {
            foreach ($timelines as $timeline) {
                $timeline->date = new DateTime($timeline->date, new DateTimeZone('America/Fortaleza'));
                $formated[$timeline->date->format('Y')][] = $timeline;
            }
            krsort($formated);
        }

        return $formated;
    }

    /**
     * @param array $data
     * @return array
     */
    protected function _filterData(array $data)
    {
        $result = array();

        foreach ($data as $row => $value) {
            switch (strtolower($row)) {
                case 'id':
                    $result['id'] = $value;
                    break;
                case 'title':
                    $result['title'] = $value;
                    break;
                case 'link':
                    $result['link'] = $value;
                    break;
                case 'content':
                case 'text':
                    $result['content'] = $value;
                    break;
                case 'image':
                    $result['image'] = $value;
                    break;
                case 'date':
                    $result['date'] = $this->_formatDate($value);
                    break;
            }
        }

        return $result;
    }

    public function log($action, $stuff)
    {
        ;
    }

}