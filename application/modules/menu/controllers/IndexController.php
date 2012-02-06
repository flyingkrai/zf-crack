<?php

class Menu_IndexController extends Zend_Controller_Action
{

    /**
     * @var Application_Model_Menu
     *
     *
     */
    protected $model = null;

    public function init()
    {
        $this->model = new Application_Model_Menu();

        $this->view->totalMenus = $this->model->count();
        $this->view->title = "Menus";
        $this->view->headTitle($this->view->title);
    }

    public function indexAction()
    {
        $this->view->title .= " - Listar";

        $menus = $this->model->findAll();
        $this->view->menus = ($menus) ? $menus : array();
    }

    public function newAction()
    {
        $this->view->title .= " - Novo";

        $request = $this->getRequest();
        $form = new Lib_Form_Menu();

        if ($request->isPost()) {
            try {
                if ($form->isValid($_POST)) {

                    $this->model->save($_POST);

                    $this->_helper->FlashMessenger('Cadastro do menu <strong><i>&OpenCurlyDoubleQuote;' . $form->getValue('title') . '&CloseCurlyDoubleQuote;</i></strong> realizado');
                    return $this->_redirect('admin/menu');
                }
            } catch (Exception $ex) {
                $this->_helper->FlashMessenger($ex->getMessage());
            }
        }

        $this->view->form = $form;
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $id = $request->getParam('id');
        if (!$id) {
            $this->_helper->FlashMessenger('ID do menu não informado');
            return $this->_redirect('admin/menu');
        }

        $menu = $this->model->find($id);
        if (!$menu) {
            $this->_helper->FlashMessenger('Menu não encontrado');
            return $this->_redirect('admin/menu');
        }

        $form = new Lib_Form_Menu();
        if ($request->isPost()) {
            try {
                if ($form->isValid($_POST)) {
                    $this->model->save($_POST);

                    $this->_helper->FlashMessenger('<strong><i>&OpenCurlyDoubleQuote;' . $form->getValue('title') . '&CloseCurlyDoubleQuote;</i></strong> atualizado');
                    return $this->_redirect('admin/menu');
                }
            } catch (Exception $ex) {
                $this->_helper->FlashMessenger($ex->getMessage());
            }
        } else {
            $form->populate(array(
                'id' => $menu->id,
                'title' => $menu->title,
                'link' => $menu->link,
                'target' => $menu->target,
                'page_id' => '',
                'order' => $menu->sequence,
            ));
        }

        $this->view->form = $form;
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        $id = $request->getParam('id');
        if (!$id) {
            $this->_helper->FlashMessenger('ID do menu não informado');
            return $this->_redirect('admin/menu');
        }

        $menu = $this->model->find($id);
        if (!$menu) {
            $this->_helper->FlashMessenger('Menu não encontrado');
            return $this->_redirect('admin/menu');
        }

        if ($request->getParam('confirm')) {
            try {
                $this->model->delete($id);

                $this->_helper->FlashMessenger('Menu removido');
                return $this->_redirect('admin/menu');
            } catch (Exception $ex) {
                $this->_helper->FlashMessenger($ex->getMessage());
            }
        }

        $this->view->menu = $menu;
    }

    public function logoutAction()
    {
        // action body
    }

    public function loginAction()
    {
        // action body
    }


}





