<?php

namespace Lib\Entity\Proxy;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class LibEntityPageProxy extends \Lib\Entity\Page implements \Doctrine\ORM\Proxy\Proxy
{
    private $_entityPersister;
    private $_identifier;
    public $__isInitialized__ = false;
    public function __construct($entityPersister, $identifier)
    {
        $this->_entityPersister = $entityPersister;
        $this->_identifier = $identifier;
    }
    private function _load()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            if ($this->_entityPersister->load($this->_identifier, $this) === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            unset($this->_entityPersister, $this->_identifier);
        }
    }

    
    public function updatedEvent()
    {
        $this->_load();
        return parent::updatedEvent();
    }

    public function getId()
    {
        $this->_load();
        return parent::getId();
    }

    public function setId($id)
    {
        $this->_load();
        return parent::setId($id);
    }

    public function getTitle()
    {
        $this->_load();
        return parent::getTitle();
    }

    public function setTitle($title)
    {
        $this->_load();
        return parent::setTitle($title);
    }

    public function getUrl()
    {
        $this->_load();
        return parent::getUrl();
    }

    public function setUrl($url)
    {
        $this->_load();
        return parent::setUrl($url);
    }

    public function getContent()
    {
        $this->_load();
        return parent::getContent();
    }

    public function setContent($content)
    {
        $this->_load();
        return parent::setContent($content);
    }

    public function getCreated()
    {
        $this->_load();
        return parent::getCreated();
    }

    public function getUpdated()
    {
        $this->_load();
        return parent::getUpdated();
    }

    public function getMenu()
    {
        $this->_load();
        return parent::getMenu();
    }

    public function setMenu($menu)
    {
        $this->_load();
        return parent::setMenu($menu);
    }

    public function __set($name, $value)
    {
        $this->_load();
        return parent::__set($name, $value);
    }

    public function __get($name)
    {
        $this->_load();
        return parent::__get($name);
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'title', 'url', 'content', 'created', 'updated', 'menu');
    }
}