<?php

class Log_IndexController extends Zend_Controller_Action
{

    /**
     * @var Application_Model_Log 
     *
     */
    protected $model = null;

    /**
     * @return bool
     */
    protected function _isAdmin()
    {
        $user = Zend_Auth::getInstance()->getIdentity();
        return ($user->is_admin);
    }

    /**
     * Check if the current user CAN TOUCH THIS
     */
    protected function _canTouchThis()
    {
        if (!$this->_isAdmin()) {
            $this->_helper->FlashMessenger('Você não tem acesso a esta funcionalidade');
            return $this->_redirect(BASE_URL .  'admin/dashboard');
        }
    }

    public function init()
    {
        $this->_canTouchThis();
        
        $this->model = new Application_Model_Log();

        $this->view->totalLogs = $this->model->count();
        $this->view->title = "Logs";
        $this->view->headTitle($this->view->title);
    }

    public function indexAction()
    {
        $this->view->title .= " - Listar";
        $this->view->logs = $this->model->findAll();
    }

    public function viewAction()
    {
        $this->view->title .= " - Ver";

        $request = $this->getRequest();
        $id = $request->getParam('id');
        if (!$id) {
            $this->_helper->FlashMessenger('ID do menu não informado');
            return $this->_redirect(BASE_URL .  'admin/menu');
        }

        $log = $this->model->find($id);
        if (!$log) {
            $this->_helper->FlashMessenger('Log não encontrado');
            return $this->_redirect(BASE_URL .  'admin/log');
        }
        $user = $log->findParentRow('Application_Model_DbTable_User');


        $this->view->user = $user;
        $this->view->log = $log;
    }

}

