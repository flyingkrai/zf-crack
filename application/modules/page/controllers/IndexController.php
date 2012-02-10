<?php

/**
 * @author Davi Alves
 */
class Page_IndexController extends Zend_Controller_Action
{

    /**
     * @var Application_Model_Page
     */
    protected $model;

    public function init()
    {
        $this->model = new Application_Model_Page();

        $this->view->totalPages = $this->model->count();
        $this->view->title = "Páginas";
        $this->view->headTitle($this->view->title);
    }

    public function indexAction()
    {
        $this->view->title .= " - Listar";

        $pages = $this->model->findAll();
        $this->view->pages = ($pages) ? $pages : array();
    }

    public function newAction()
    {
        $this->view->title .= " - Nova";

        $request = $this->getRequest();
        $form = new Lib_Form_Page();

        if ($request->isPost()) {
            try {
                if ($form->isValid($_POST)) {

                    $this->model->save($_POST);

                    $this->_helper->FlashMessenger('Cadastro da página <strong><i>&OpenCurlyDoubleQuote;' . $form->getValue('title') . '&CloseCurlyDoubleQuote;</i></strong> realizado');
                    return $this->_redirect(BASE_URL .  'admin/page');
                }
            } catch (Exception $ex) {
                $this->_helper->FlashMessenger($ex->getMessage());
            }
        }

        $this->view->form = $form;
    }

    public function editAction()
    {
        $this->view->title .= " - Editar";

        $request = $this->getRequest();
        $id = $request->getParam('id');
        if (!$id) {
            $this->_helper->FlashMessenger('ID da página não informado');
            return $this->_redirect(BASE_URL .  'admin/page');
        }

        $page = $this->model->find($id);
        if (!$page) {
            $this->_helper->FlashMessenger('Página não encontrado');
            return $this->_redirect(BASE_URL .  'admin/page');
        }

        $form = new Lib_Form_Page();
        if ($request->isPost()) {
            try {
                if ($form->isValid($_POST)) {
                    $this->model->save($_POST);

                    $this->_helper->FlashMessenger('<strong><i>&OpenCurlyDoubleQuote;' . $form->getValue('title') . '&CloseCurlyDoubleQuote;</i></strong> atualizado');
                    return $this->_redirect(BASE_URL .  'admin/page');
                }
            } catch (Exception $ex) {
                $this->_helper->FlashMessenger($ex->getMessage());
            }
        } else {
            $form->populate(array(
                'id' => $page->id,
                'title' => $page->title,
                'url' => $page->url,
                'text' => $page->content,
            ));
        }

        $this->view->form = $form;
    }

    public function deleteAction()
    {
        $this->view->title .= " - Deletar";

        $request = $this->getRequest();
        $id = $request->getParam('id');
        if (!$id) {
            $this->_helper->FlashMessenger('ID da página não informado');
            return $this->_redirect(BASE_URL .  'admin/page');
        }

        $page = $this->model->find($id);
        if (!$page) {
            $this->_helper->FlashMessenger('Página não encontrada');
            return $this->_redirect(BASE_URL .  'admin/page');
        }

        if ($request->getParam('confirm')) {
            try {
                $this->model->delete($id);

                $this->_helper->FlashMessenger('Página removida');
                return $this->_redirect(BASE_URL .  'admin/page');
            } catch (Exception $ex) {
                $this->_helper->FlashMessenger($ex->getMessage());
            }
        }

        $this->view->page = $page;
    }

}

