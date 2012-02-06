<?php

namespace Lib\Entity;

/**
 * Description of Timeline
 *
 * @author davi
 * @Table(name="timeline")
 * @Entity
 */
class Timeline extends Base
{

    /**
     * @var integer $id
     * @Column(type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $title
     * @Column(type="string", length=200, nullable=false)
     */
    private $title;

    /**
     * @var string $link
     * @Column(type="string", length=200, nullable=false)
     */
    private $link;

    /**
     * @var string $content
     * @Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @var string $image
     * @Column(type="text", nullable=true)
     */
    private $image;

    /**
     * @var datetime
     * @Column(type="datetime", nullable=false)
     */
    private $date;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer
     * @return \Lib\Entity\Timeline
     */
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string
     * @return \Lib\Entity\Timeline
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string
     * @return \Lib\Entity\Timeline
     */
    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string
     * @return \Lib\Entity\Timeline
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string
     * @return \Lib\Entity\Timeline
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime
     * @return \Lib\Entity\Timeline
     */
    public function setDate($date)
    {
        if (!$date instanceof \DateTime) {
            $date = new \Zend_Date($date);
            $date = new \DateTime($date->toString('yyyy-MM-dd H:m'));
        }
        $this->date = $date;
        return $this;
    }

}
