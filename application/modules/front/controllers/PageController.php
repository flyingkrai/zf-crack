<?php

class Front_PageController extends Zend_Controller_Action
{

    public function init()
    {
        $menuModel = new Application_Model_Menu();
        $timelineModel = new Application_Model_Timeline();

        $menus = $menuModel->findAllOrdened();
        $timeline = $timelineModel->getFormatedTimeline();

        $this->view->menus = ($menus->count() > 0) ? $menus : array();
        $this->view->timeline = $timeline;
    }

    public function indexAction()
    {
        if ($this->getRequest()->getParam('page') != 'test' || !$this->_helper->auth->hasAuth()) {
            $this->_redirect(BASE_URL);
        }
    }

    public function generateAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_redirect(BASE_URL);
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

        $this->_redirect(BASE_URL . 'admin/dashboard');
    }

}

