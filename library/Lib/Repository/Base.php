<?php

namespace Lib\Repository;

/**
 * Description of Base
 *
 * @author davi
 */
abstract class Base
{

    /**
     * @param string $entityName
     * @return Doctrine\ORM\EntityRepository
     */
    public function getEntityRepository($entityName)
    {
        $em = \Zend_Registry::get('doctrine')->getEntityManager();
        /** @var Doctrine\ORM\EntityManager $em * */
        return $em->getRepository($entityName);
    }

    /**
     * @return Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return \Zend_Registry::get('doctrine')->getEntityManager();
    }

    /**
     * Find by indetifier
     * 
     * @param $id
     */
    abstract public function find($id);

    /**
     * Find all
     */
    abstract public function findAll();

    /**
     * Count total
     */
    abstract public function count();

    /**
     * @param array $data
     */
    abstract public function save($data);

    /**
     * @param int $id
     */
    abstract public function delete($id);
}
