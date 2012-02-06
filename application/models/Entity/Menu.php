<?php

/**
 * Description of Menu
 *
 * @author davi
 */
class Application_Model_Entity_Menu extends Application_Model_Entity_Base
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
     * @var string $target
     */
    private $target;

    /**
     * @var integer $sequence
     */
    private $sequence;

    /**
     * @var Application_Model_Entity_Page
     */
    private $page;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer
     * @return Application_Model_Entity_Menu
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return Application_Model_Entity_Menu
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
     * @return Application_Model_Entity_Menu
     */
    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param string
     * @return Application_Model_Entity_Menu
     */
    public function setTarget($target)
    {
        $this->target = $target;
        return $this;
    }

    /**
     * @return integer
     */
    public function getSequence()
    {
        return $this->sequence;
    }

    /**
     * @param integer
     * @return Application_Model_Entity_Menu
     */
    public function setSequence($sequence)
    {
        $this->sequence = $sequence;
        return $this;
    }

    /**
     * @return Application_Model_Entity_Page
     */
    public function getPage()
    {
        if (!$this->page) {
            $this->page = new Application_Model_Entity_Page();
        }
        return $this->page;
    }

    /**
     * @param Application_Model_Entity_Page
     * @return Application_Model_Entity_Menu
     */
    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }

}
