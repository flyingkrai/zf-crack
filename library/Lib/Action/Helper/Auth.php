<?php

/**
 * Description of Auth
 *
 * @author davi
 */
class Lib_Action_Helper_Auth extends Zend_Controller_Action_Helper_Abstract
{

    /**
     * @var string Admin role ID
     */
    protected $admin_role = 'admin';

    /**
     * @var Zend_View_Interface
     */
    protected $view;

    /**
     * @return Zend_View_Interface 
     */
    protected function _getView()
    {
        if ($this->view == null) {
            $this->view = $this->getActionController()->view;
        }

        return $this->view;
    }

    /**
     * @return boolean
     */
    public function hasAuth()
    {
        return Zend_Auth::getInstance()->hasIdentity();
    }

    /**
     * @return stdClass|null
     */
    public function getCurrentUser()
    {
        $indetity = null;
        if ($this->hasAuth()) {
            $indetity = Zend_Auth::getInstance()->getIdentity();
        }

        return $indetity;
    }

    /**
     * @return bool
     */
    public function isAdmin($user = null)
    {
        if (!$user) {
            $user = $this->getCurrentUser();
        }

        return @($user->role == $this->admin_role);
    }

    /**
     * @return string
     */
    public function getAdminRole()
    {
        return $this->admin_role;
    }

    public function preDispatch()
    {
        $view = $this->_getView();
        $view->isAdmin = $this->isAdmin();
    }

}
