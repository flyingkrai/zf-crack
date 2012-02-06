<?php

/**
 * @author davi
 */
class Application_Model_Entity_Page extends Application_Model_Entity_Base
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
     * @var string $url
     */
    private $url;

    /**
     * @var string $name
     */
    private $content;

    /**
     * @var datetime
     */
    private $created;

    /**
     * @var datetime
     */
    private $updated;

    /**
     * @var Application_Model_Entity_Menu
     */
    private $menu;

    public function __construct()
    {
        $this->created = new DateTime(date("Y-m-d H:i:s"), new DateTimeZone('America/Fortaleza'));
    }

    /**
     * @PreUpdate
     */
    public function updatedEvent()
    {
        $this->updated = new DateTime(date("Y-m-d H:i:s"), new DateTimeZone('America/Fortaleza'));
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     * @return Application_Model_Entity_Page
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return strint
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Application_Model_Entity_Page
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Application_Model_Entity_Page
     */
    public function setUrl($url)
    {
        $this->url = $url;
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
     * @param string $content
     * @return Application_Model_Entity_Page
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @return Application_Model_Entity_Menu
     */
    public function getMenu()
    {
        if (!$this->menu) {
            $this->menu = new Menu();
        }
        return $this->menu;
    }

    /**
     * @param Application_Model_Entity_Menu
     * @return Application_Model_Entity_Page
     */
    public function setMenu($menu)
    {
        $this->menu = $menu;
        return $this;
    }

}
