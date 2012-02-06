<?php

namespace Lib\Repository;
/**
 * Description of Menu
 *
 * @author davi
 */
class Menu extends Base
{


    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em = null;

    public function __construct()
    {
        $this->em = $this->getEntityManager();
    }

    /**
     * @return integer
     */
    public function count()
    {
        $result = 0;
        try {
            $result = $this->em->createQuery("SELECT count(m.id) as total FROM \Lib\Entity\Menu m")->getSingleResult();
            $result = $result['total'];
        } catch (Exception $ex) {

        }

        return (int)$result;
    }

    /**
     * @param type $id
     * @return \Lib\Entity\Menu
     */
    public function find($id)
    {
        return $this->em->find('\Lib\Entity\Menu', $id);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $menus = $this->getEntityRepository('\Lib\Entity\Menu');

        return $menus->findAll();
    }

    /**
     * @return array
     */
    public function findAllOrdened()
    {
        return $this->em->createQuery("SELECT m FROM \Lib\Entity\Menu m ORDER BY m.sequence ASC")->getResult();
    }

    public function save($data)
    {
        if (isset($data['id']) && (int)$data['id']) {
            $menu = $this->em->find('\Lib\Entity\Menu', $data['id']);
        } else {
            $menu = new \Lib\Entity\Menu();
        }

        $page = null;
        if (isset($data['page_id']) && (int)$data['page_id']) {
            $page = $this->em->find('\Lib\Entity\Page', $data['page_id']);
        }

        $menu->setPage($page)
            ->setTitle($data['title'])
            ->setLink($data['link'])
            ->setTarget($data['target'])
            ->setSequence($data['order']);

        $this->em->persist($menu);
        $this->em->flush();
    }

    public function delete($id)
    {
        $page = $this->em->find('\Lib\Entity\Menu', $id);
        $this->em->remove($page);
        $this->em->flush();
    }

}
