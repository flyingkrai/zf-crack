<?php

/**
 *
 * @author davi
 */
interface Application_Model_BaseInteface
{

    public function count();

    /**
     * @param array $data
     */
    public function save($data);

    /**
     * @param int $id
     */
    public function delete($id);
}
