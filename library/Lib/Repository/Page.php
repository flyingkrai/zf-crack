<?php

namespace Lib\Repository;

/**
 * Description of Page
 *
 * @author davi
 */
class Page extends Base
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
            $result = $this->em->createQuery("SELECT count(p.id) as total FROM \Lib\Entity\Page p")->getSingleResult();
            $result = $result['total'];
        } catch (Exception $ex) {
            
        }

        return (int) $result;
    }

    /**
     * @param type $id
     * @return \Lib\Entity\Page 
     */
    public function find($id)
    {
        return $this->em->find('\Lib\Entity\Page', $id);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $menus = $this->getEntityRepository('\Lib\Entity\Page');

        return $menus->findAll();
    }

    public function save($data)
    {
        if (isset($data['id']) && (int) $data['id']) {
            $page = $this->em->find('\Lib\Entity\Page', $data['id']);
        } else {
            $page = new \Lib\Entity\Page();
        }

        $page->setTitle($data['title'])
                ->setUrl($data['url'])
                ->setContent($data['text']);

        $this->em->persist($page);
        $this->em->flush();
    }

    public function delete($id)
    {
        $page = $this->em->find('\Lib\Entity\Page', $id);
        $this->em->remove($page);
        $this->em->flush();
    }

}
