<?php

class User_IndexController extends Zend_Controller_Action
{

    /**
     * @var Application_Model_User
     */
    protected $model;

    /**
     * @return stdClass
     */
    protected function _getCurrentUser()
    {
        return Zend_Auth::getInstance()->getIdentity();
    }

    /**
     * @return bool
     */
    protected function _isAdmin()
    {
        $user = $this->_getCurrentUser();
        return ($user->is_admin);
    }

    /**
     * Check if the current user CAN TOUCH THIS
     */
    protected function _canTouchThis()
    {
        if (!$this->_isAdmin()) {
            $user = $this->_getCurrentUser();
            $this->_forward('edit', null, null, array('id' => $user->id));
        }
    }

    public function init()
    {
        $this->model = new Application_Model_User();

        $this->view->totalUsers = $this->model->count();
        $this->view->title = "Usuários";
        $this->view->headTitle($this->view->title);
    }

    public function indexAction()
    {
        $this->_canTouchThis();
        $this->view->title .= " - Listar";

        $users = $this->model->findAll();
        $this->view->users = ($users) ? $users : array();
    }

    public function newAction()
    {
        $this->_canTouchThis();
        $this->view->title .= " - Novo";

        $request = $this->getRequest();
        $form = new Lib_Form_User();

        if ($request->isPost()) {
            try {
                if ($form->isValid($_POST)) {

                    $this->model->save($_POST);

                    $this->_helper->FlashMessenger('Cadastro do usuário <strong><i>&OpenCurlyDoubleQuote;' . $form->getValue('name') . '&CloseCurlyDoubleQuote;</i></strong> realizado');
                    return $this->_redirect('admin/user');
                }
            } catch (Exception $ex) {
                $this->_helper->FlashMessenger($ex->getMessage());
            }
        }

        $this->view->form = $form;
    }

    public function editAction()
    {
        $this->view->title .= " - Edit";

        $request = $this->getRequest();
        $id = $request->getParam('id');
        if (!$id) {
            $this->_helper->FlashMessenger('ID do usuário não informado');
            return $this->_redirect('admin/user');
        }

        $user = $this->model->find($id);
        if (!$user) {
            $this->_helper->FlashMessenger('Usuário não encontrado');
            return $this->_redirect('admin/user');
        }

        $form = new Lib_Form_User();
        $form->getElement('username')->setAttrib('readonly', true);
        if ($request->isPost()) {
            try {
                if ($form->isValid($_POST)) {
                    $this->model->save($_POST);

                    if ($this->_isAdmin()) {
                        $this->_helper->FlashMessenger('<strong><i>&OpenCurlyDoubleQuote;' . $form->getValue('name') . '&CloseCurlyDoubleQuote;</i></strong> atualizado');
                        return $this->_redirect('admin/user');
                    } else {
                        $this->_helper->FlashMessenger('Seu cadastro foi atualizado');
                        return $this->_redirect('admin/dashboard');
                    }
                }
            } catch (Exception $ex) {
                $this->_helper->FlashMessenger($ex->getMessage());
            }
        } else {
            $form->populate(array(
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
            ));
        }

        $this->view->form = $form;
    }

    public function deleteAction()
    {
        $this->_canTouchThis();
        $request = $this->getRequest();
        $id = $request->getParam('id');
        if (!$id) {
            $this->_helper->FlashMessenger('ID do usuário não informado');
            return $this->_redirect('admin/user');
        }
        if ($id == 1) {
            $this->_helper->FlashMessenger('Usuário Administrador não pode ser removido');
            return $this->_redirect('admin/user');
        }

        $user = $this->model->find($id);
        if (!$user) {
            $this->_helper->FlashMessenger('Usuário não encontrado');
            return $this->_redirect('admin/user');
        }

        if ($request->getParam('confirm')) {
            try {
                $this->model->delete($id);

                $this->_helper->FlashMessenger('Usuário removida');
                return $this->_redirect('admin/user');
            } catch (Exception $ex) {
                $this->_helper->FlashMessenger($ex->getMessage());
            }
        }

        $this->view->user = $user;
    }


}







