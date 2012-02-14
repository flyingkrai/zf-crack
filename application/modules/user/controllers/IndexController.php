<?php

/**
 * @author Davi Alves
 */
class User_IndexController extends Zend_Controller_Action
{

    /**
     * @var Application_Model_User
     */
    protected $model;

    /**
     * @param string $role
     * @return void
     */
    protected function _changedOwnRole($data)
    {
        if (!$data['role']) {
            return;
        }

        $user = $this->_helper->auth->getCurrentUser();
        if ($user->role != $role && $data['id'] == $user->id) {
            $this->_redirect(BASE_URL . 'admin/admin/logout');
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
        $this->view->title .= " - Listar";

        $users = $this->model->findAll();
        $this->view->users = ($users) ? $users : array();
    }

    public function newAction()
    {
        $this->view->title .= " - Novo";

        $request = $this->getRequest();
        $form = new Lib_Form_User();
        $form->getElement('password')->setRequired();
        $form->getElement('password_confirm')->setRequired();

        if ($request->isPost()) {
            try {
                if ($form->isValid($_POST)) {

                    $this->model->save($_POST);

                    $this->_helper->FlashMessenger('Cadastro do usuário <strong><i>&OpenCurlyDoubleQuote;' . $form->getValue('name') . '&CloseCurlyDoubleQuote;</i></strong> realizado');
                    return $this->_redirect(BASE_URL . 'admin/user');
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
            return $this->_redirect(BASE_URL . 'admin/user');
        }

        $user = $this->model->find($id);
        if (!$user) {
            $this->_helper->FlashMessenger('Usuário não encontrado');
            return $this->_redirect(BASE_URL . 'admin/user');
        }

        $form = new Lib_Form_User();
        $form->getElement('username')->setAttrib('readonly', true);
        if (!$this->_helper->auth->isAdmin()) {
            $form->getElement('role')->setAttrib('disabled', true);
        }
        if ($request->isPost()) {
            try {
                if ($form->isValid($_POST)) {
                    $this->model->save($_POST);
                    $this->_changedOwnRole($_POST);

                    if ($this->_helper->auth->isAdmin()) {
                        $this->_helper->FlashMessenger('<strong><i>&OpenCurlyDoubleQuote;' . $form->getValue('name') . '&CloseCurlyDoubleQuote;</i></strong> atualizado');
                        return $this->_redirect(BASE_URL . 'admin/user');
                    } else {
                        $this->_helper->FlashMessenger('Seu cadastro foi atualizado');
                        return $this->_redirect(BASE_URL . 'admin/dashboard');
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
                'role' => $user->role,
                'password' => '',
                'password_confirm' => ''
            ));
        }

        $this->view->form = $form;
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        $id = $request->getParam('id');
        if (!$id) {
            $this->_helper->FlashMessenger('ID do usuário não informado');
            return $this->_redirect(BASE_URL . 'admin/user');
        }

        $user = $this->model->find($id);
        if (!$user) {
            $this->_helper->FlashMessenger('Usuário não encontrado');
            return $this->_redirect(BASE_URL . 'admin/user');
        }

        if ($this->_helper->auth->isAdmin($user)) {
            $this->_helper->FlashMessenger('Usuário Administrador não pode ser removido');
            return $this->_redirect(BASE_URL . 'admin/user');
        }

        if ($request->getParam('confirm')) {
            try {
                $this->model->delete($id);

                $this->_helper->FlashMessenger('Usuário removida');
                return $this->_redirect(BASE_URL . 'admin/user');
            } catch (Exception $ex) {
                $this->_helper->FlashMessenger($ex->getMessage());
            }
        }

        $this->view->user = $user;
    }

}

