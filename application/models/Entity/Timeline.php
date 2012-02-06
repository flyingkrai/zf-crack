<?php

/**
 * Description of Timeline
 *
 * @author davi
 */
class Application_Model_Entity_Timeline extends Application_Model_Entity_Base
{

    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $title
     */
    private $title;

    /**
     * @var string $link
     */
    private $link;

    /**
     * @var string $content
     */
    private $content;

    /**
     * @var string $image
     */
    private $image;

    /**
     * @var datetime
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
     * @return Application_Model_Entity_Timeline
     */
    public function setId($id)
    {
        $this->id = (int)$id;
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
     * @return Application_Model_Entity_Timeline
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
     * @return Application_Model_Entity_Timeline
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
     * @return Application_Model_Entity_Timeline
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
     * @return Application_Model_Entity_Timeline
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param DateTime
     * @return Application_Model_Entity_Timeline
     */
    public function setDate($date)
    {
        if (!$date instanceof DateTime) {
            $date = new Zend_Date($date);
            $date = new DateTime($date->toString('yyyy-MM-dd H:m'));
        }
        $this->date = $date;
        return $this;
    }

}
