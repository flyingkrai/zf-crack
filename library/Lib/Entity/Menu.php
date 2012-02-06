<?php

namespace Lib\Entity;

/**
 * Description of Menu
 *
 * @author davi
 * @Table(name="menu")
 * @Entity
 */
class Menu extends Base
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
     * @var string $target
     * @Column(type="string", length=10, nullable=false)
     */
    private $target;

    /**
     * @var integer $sequence
     * @Column(type="integer", nullable=false)
     */
    private $sequence;

    /**
     * @var Lib\Entity\Page 
     * @OneToOne(targetEntity="Page")
     * @JoinColumn(name="page_id", referencedColumnName="id")
     */
    private $page;

    public function __construct()
    {
        $this->page = new \Lib\Entity\Page();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer
     * @return Lib\Entity\Menu
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
     * @return Lib\Entity\Menu
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
     * @return Lib\Entity\Menu
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
     * @return Lib\Entity\Menu
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
     * @return Lib\Entity\Menu
     */
    public function setSequence($sequence)
    {
        $this->sequence = $sequence;
        return $this;
    }

    /**
     * @return Lib\Entity\Page
     */
    public function getPage()
    {
        if (!$this->page) {
            $this->page = new Page();
        }
        return $this->page;
    }

    /**
     * @param Lib\Entity\Page
     * @return Lib\Entity\Menu
     */
    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }

}
