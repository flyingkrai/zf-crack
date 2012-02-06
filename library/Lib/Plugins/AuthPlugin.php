<?php

/**
 * @author Davi Alves
 */
class Lib_Plugins_AuthPlugin extends Zend_Controller_Plugin_Abstract
{
    /**
     * @return bool
     */
    protected function _hasAuth()
    {
        return Zend_Auth::getInstance()->hasIdentity();
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $module = $request->getModuleName();
        $action = $request->getActionName();
        if ($module == 'front' && $action == 'generate' && !$this->_hasAuth()) {
            $request->setModuleName('admin')
                ->setControllerName('Index')
                ->setActionName('login');
        } elseif ($module != 'front' && !$this->_hasAuth()) {
            $request->setModuleName('admin')
                ->setControllerName('Index')
                ->setActionName('login');

        }

        return $request;
    }
}
