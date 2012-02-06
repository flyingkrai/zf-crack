<?php

/**
 * Gerencia as mensagens de alerta
 *
 * @author davi
 */
class Lib_Action_Helper_Messenger extends Zend_Controller_Action_Helper_Abstract
{

    /**
     * @var Zend_View_Interface
     */
    protected $view;

    public function preDispatch()
    {
        $view = $this->getView();
        $helper = $this->getActionController()->getHelper('FlashMessenger');
        $view->messages = $helper->getMessages();
    }

    /**
     * @return Zend_View_Interface
     */
    public function getView()
    {
        if (null !== $this->view) {
            return $this->view;
        }

        $controller = $this->getActionController();
        $this->view = $controller->view;

        return $this->view;
    }

}
