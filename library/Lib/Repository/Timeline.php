<?php

namespace Lib\Repository;

/**
 * Description of Timeline
 *
 * @author davi
 */
class Timeline extends Base
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
            $result = $this->em->createQuery("SELECT count(t.id) as total FROM \Lib\Entity\Timeline t")->getSingleResult();
            $result = $result['total'];
        } catch (Exception $ex) {
            
        }

        return (int) $result;
    }

    /**
     * @param array $data 
     */
    public function save($data)
    {
        if (isset($data['id']) && (int) $data['id']) {
            $timeline = $this->em->find('\Lib\Entity\Timeline', $data['id']);
            if ($data['image'] && $data['image'] != $timeline->image) {
                $this->deleteImage($data['id']);
            }
        } else {
            $timeline = new \Lib\Entity\Timeline();
        }

        $timeline->setTitle($data['title'])
                ->setLink($data['link'])
                ->setContent($data['text'])
                ->setImage($data['image'])
                ->setDate($data['date']);

        $this->em->persist($timeline);
        $this->em->flush();
    }

    public function delete($id)
    {
        $timeline = $this->em->find('\Lib\Entity\Timeline', $id);
        $this->em->remove($timeline);
        $this->em->flush();
    }

    public function deleteImage($id)
    {
        $timeline = $this->em->find('\Lib\Entity\Timeline', $id);
        @unlink(UPLOAD_PATH . $timeline->image);
        $timeline->setImage('');
        $this->em->persist($timeline);
        $this->em->flush();
    }

    /**
     * @param type $id
     * @return Lib\Entity\Timeline 
     */
    public function find($id)
    {
        return $this->em->find('\Lib\Entity\Timeline', $id);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $timelines = $this->getEntityRepository('\Lib\Entity\Timeline');

        return $timelines->findAll();
    }

    /**
     * @return array
     */
    public function getFormatedTimeline()
    {
        $formated = array();
        $timelines = $this->em->createQuery("SELECT t FROM \Lib\Entity\Timeline t ORDER BY t.date DESC")->getResult();
        foreach ($timelines as $timeline) {
            $formated[$timeline->date->format('Y')][] = $timeline;
        }
        krsort($formated);
        
        return $formated;
    }

}
