<?php

namespace Lib\Entity;

/**
 * @author davi
 * @Table(name="page")
 * @Entity 
 * @HasLifecycleCallbacks
 */
class Page extends Base
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
     * @var string $url
     * @Column(type="string", length=255, nullable=false)
     */
    private $url;

    /**
     * @var string $name
     * @Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @var datetime
     * @Column(type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var datetime
     * @Column(type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @var Lib\Entity\Menu 
     * @OneToOne(targetEntity="Menu", mappedBy="page", cascade={"persist", "remove", "merge"})
     */
    private $menu;

    public function __construct()
    {
        $this->created = new \DateTime(date("Y-m-d H:i:s"), new \DateTimeZone('America/Fortaleza'));
    }

    /**
     * @PreUpdate
     */
    public function updatedEvent()
    {
        $this->updated = new \DateTime(date("Y-m-d H:i:s"), new \DateTimeZone('America/Fortaleza'));
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
     * @return \Lib\Entity\Page
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
     * @return \Lib\Entity\Page
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
     * @return \Lib\Entity\Page
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
     * @return \Lib\Entity\Page
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @return Lib\Entity\Menu
     */
    public function getMenu()
    {
        if (!$this->menu) {
            $this->menu = new Menu();
        }
        return $this->menu;
    }

    /**
     * @param Lib\Entity\Menu
     * @return Lib\Entity\Page
     */
    public function setMenu($menu)
    {
        $this->menu = $menu;
        return Lib\Entity\Page;
    }

}
