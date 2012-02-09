<?php

class Front_PageController extends Zend_Controller_Action
{

    public function init()
    {
        $menuModel = new Application_Model_Menu();
        $timelineModel = new Application_Model_Timeline();

        $this->view->menus = $menuModel->findAllOrdened();
        $this->view->timeline = $timelineModel->getFormatedTimeline();
    }

    public function indexAction()
    {
        if ($this->getRequest()->getParam('page') != 'test' || !Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/');
        }
    }

    public function generateAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_redirect('/');
        }
        $log = new Application_Model_Log();

        try {
            $layout = $this->_helper->layout();
            $layout->disableLayout();
            $layout->content = $this->render('index');
            $html = $layout->render();

            @file_put_contents(APPLICATION_PATH . '/../index.html', $html);
            $log->publicLog('capa', 'generate', null, null);
            $this->_helper->FlashMessenger('Capa gerada!');
        } catch (Exception $exc) {
            $this->_helper->FlashMessenger($exc->getMessage());
        }

        $this->_redirect('admin/dashboard');
    }

}

