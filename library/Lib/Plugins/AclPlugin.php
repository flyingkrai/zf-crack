<?php

/**
 * Description of AclPlugin
 *
 * @author davi
 */
class Lib_Plugins_AclPlugin extends Zend_Controller_Plugin_Abstract
{

    /**
     * @var Zend_Acl
     */
    protected $acl;

    /* ROLES */
    const ROLE_ADMIN = 'admin';
    const ROLE_COLABORATOR = 'colaborador';
    const ROLE_EDITOR = 'editor';
    const ROLE_USER = 'usuario';
    /* /ROLES */

    /* RESOURCES */
    const RESOURCE_LOG = 'log';
    const RESOURCE_ADMIN = 'admin';
    const RESOURCE_MENU = 'menu';
    const RESOURCE_TIMELINE = 'timeline';
    const RESOURCE_FRONT = 'front';
    const RESOURCE_USER = 'user';
    /* /RESOURCES */

    public function __construct()
    {
        // ACL instance
        $acl = new Zend_Acl();

        /* ROLES */
        $acl->addRole(new Zend_Acl_Role(self::ROLE_USER));
        $acl->addRole(new Zend_Acl_Role(self::ROLE_EDITOR), self::ROLE_USER);
        $acl->addRole(new Zend_Acl_Role(self::ROLE_COLABORATOR), self::ROLE_EDITOR);
        $acl->addRole(new Zend_Acl_Role(self::ROLE_ADMIN), self::ROLE_COLABORATOR);
        /* /ROLES */

        $this->acl = $acl;

        /* RESOURCES & PERMISSIONS */
        $this->_frontAcl();
        $this->_usertAcl();
        $this->_logAcl();
        $this->_menuAcl();
        $this->_timelineAcl();
        $this->_adminAcl();
        /* /RESOURCES & PERMISSIONS */
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $auth = Zend_Auth::getInstance();

        $module = $request->getModuleName();
        $controller = $request->getControllerName();
        $action = $request->getActionName();

        if ($auth->hasIdentity()) {
            $user = $auth->getIdentity();

            if ($module == self::RESOURCE_USER && $user->role != self::ROLE_ADMIN) {
                $request->clearParams()
                        ->setModuleName('user')
                        ->setControllerName('Index')
                        ->setActionName('edit')
                        ->setParam('id', $user->id);
            } elseif (!$this->acl->isAllowed($user->role, $module, "$controller:$action")) {
                $request->clearParams()
                        ->setModuleName('admin')
                        ->setControllerName('Index')
                        ->setActionName('error')
                        ->setParam('error', 'Você não tem permissão para acessar essa funcionalidade');
            }
        } else {
            $request->clearParams()
                    ->setModuleName('admin')
                    ->setControllerName('Index')
                    ->setActionName('login');
        }
    }

    /**
     * Front resource & permissions
     */
    protected function _frontAcl()
    {
        // add resource
        $this->acl->addResource(new Zend_Acl_Resource(self::RESOURCE_FRONT));

        // set permissions
        $this->acl->allow(self::ROLE_USER, self::RESOURCE_FRONT, array('Page:index', 'Page:generate'));
    }

    /**
     * User resource & permissions
     */
    protected function _usertAcl()
    {
        // add resource
        $this->acl->addResource(new Zend_Acl_Resource(self::RESOURCE_USER));

        // set permissions
        $this->acl->allow(self::ROLE_USER, self::RESOURCE_USER, array('Index:edit'));
        $this->acl->allow(self::RESOURCE_ADMIN, self::RESOURCE_USER, array('Index:index', 'Index:new', 'Index:edit', 'Index:delete'));
    }

    /**
     * Log resource & permissions
     */
    protected function _logAcl()
    {
        // add resource
        $this->acl->addResource(new Zend_Acl_Resource(self::RESOURCE_LOG));

        // set permissions
        $this->acl->allow(self::ROLE_ADMIN, self::RESOURCE_LOG, array('Index:index', 'Index:view'));
    }

    /**
     * Admin resource & permissions
     */
    protected function _adminAcl()
    {
        // add resource
        $this->acl->addResource(new Zend_Acl_Resource(self::RESOURCE_ADMIN));

        // set permissions
        $this->acl->allow(self::ROLE_USER, self::RESOURCE_ADMIN, array('Index:index', 'Index:login', 'Index:logout', 'Index:opengraph'));
    }

    /**
     * Menu resource & permissions
     */
    protected function _menuAcl()
    {
        // add resource
        $this->acl->addResource(new Zend_Acl_Resource(self::RESOURCE_MENU));

        // set permissions
        $this->acl->allow(self::ROLE_USER, self::RESOURCE_MENU, array('Index:index', 'Index:new', 'Index:edit', 'Index:delete'));
    }

    /**
     * Timeline resource & permissions
     */
    protected function _timelineAcl()
    {
        // add resource
        $this->acl->addResource(new Zend_Acl_Resource(self::RESOURCE_TIMELINE));

        // set permissions
        $this->acl->allow(self::ROLE_USER, self::RESOURCE_TIMELINE, array('Index:index', 'Index:new', 'Index:edit', 'Index:delete', 'Index:image', 'Index:crop'));
    }

}
