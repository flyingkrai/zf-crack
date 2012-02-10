<?php

class Timeline_IndexController extends Zend_Controller_Action
{

    /**
     * @var Application_Model_Timeline
     *
     *
     */
    protected $model = null;

    /**
     * Handle file upload
     * @return string
     *
     */
    protected function _uploadImage()
    {
        $upload = new Zend_File_Transfer_Adapter_Http();

        if ($upload->isUploaded()) {
            $fileInfo = $upload->getFileInfo();
            $fileType = str_replace('image/', '', $fileInfo['image']['type']);
            $fileName = $this->_helper->fileUpload->generateFileName($fileType);
            $filePath = $this->_helper->fileUpload('timeline');

            $upload->setDestination($filePath);
            $upload->addFilter('Rename', $fileName);

            $upload->receive();

            return str_replace(UPLOAD_PATH, '', "$filePath/$fileName");
        }

        return false;
    }

    /**
     * @param string $image image relative path
     */
    protected function _deleteImage($image)
    {
        $img = explode('.', $image);

        @unlink(UPLOAD_PATH . $img[0] . '_272x272.' . $img[1]);
        @unlink(UPLOAD_PATH . $image);
    }

    public function init()
    {
        $this->model = new Application_Model_Timeline();

        $this->view->totalEvents = $this->model->count();
        $this->view->title = "Timeline";
        $this->view->headTitle($this->view->title);
    }

    public function indexAction()
    {
        $this->view->title .= " - Listar";

        $timeline = $this->model->findAll();
        $this->view->timelines = $timeline;
    }

    public function newAction()
    {
        $this->view->title .= " - Novo";

        $request = $this->getRequest();
        $form = new Lib_Form_Timeline();

        if ($request->isPost()) {
            try {
                if ($form->isValid($_POST)) {
                    $upload = $this->_uploadImage();
                    $_POST['image'] = ($upload) ? $upload : null;

                    $id = $this->model->save($_POST);

                    $this->_helper->FlashMessenger('Cadastro de <strong><i>&OpenCurlyDoubleQuote;' . $form->getValue('title') . '&CloseCurlyDoubleQuote;</i></strong> realizado');
                    if ($upload) {
                        return $this->_redirect(BASE_URL .  'admin/timeline/crop/id/' . $id);
                    } else {
                        return $this->_redirect(BASE_URL .  'admin/timeline');
                    }
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
            $this->_helper->FlashMessenger('ID do evento não informado');
            return $this->_redirect(BASE_URL .  'admin/timeline');
        }

        $timeline = $this->model->find($id);
        if (!$timeline) {
            $this->_helper->FlashMessenger('Evento não encontrado');
            return $this->_redirect(BASE_URL .  'admin/timeline');
        }

        $form = new Lib_Form_Timeline();
        if ($request->isPost()) {
            try {
                if ($form->isValid($_POST)) {

                    $upload = $this->_uploadImage();
                    $_POST['image'] = ($upload) ? $upload : $timeline->image;
                    if ($upload) {
                        $this->_deleteImage($timeline->image);
                    }
                    $id = $this->model->save($_POST);

                    $this->_helper->FlashMessenger('<strong><i>&OpenCurlyDoubleQuote;' . $form->getValue('title') . '&CloseCurlyDoubleQuote;</i></strong> atualizado');
                    if ($upload) {
                        return $this->_redirect(BASE_URL .  'admin/timeline/crop/id/' . $id);
                    } else {
                        return $this->_redirect(BASE_URL .  'admin/timeline');
                    }
                }
            } catch (Exception $ex) {
                $this->_helper->FlashMessenger($ex->getMessage());
            }
        } else {
            $form->populate(array(
                'id' => $timeline->id,
                'title' => $timeline->title,
                'link' => $timeline->link,
                'date' => $timeline->date,
                'text' => $timeline->content,
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
            $this->_helper->FlashMessenger('ID do evento não informado');
            return $this->_redirect(BASE_URL .  'admin/timeline');
        }

        $timeline = $this->model->find($id);
        if (!$timeline) {
            $this->_helper->FlashMessenger('Evento não encontrado');
            return $this->_redirect(BASE_URL .  'admin/timeline');
        }

        if ($request->getParam('confirm')) {
            try {
                $this->_deleteImage($timeline->image);
                $this->model->delete($id);

                $this->_helper->FlashMessenger('Evento removido');
                return $this->_redirect(BASE_URL .  'admin/timeline');
            } catch (Exception $ex) {
                $this->_helper->FlashMessenger($ex->getMessage());
            }
        }

        $this->view->timeline = $timeline;
    }

    public function imageAction()
    {
        $this->view->title .= " - Remover Imagem";

        $request = $this->getRequest();
        $id = $request->getParam('id');
        if (!$id) {
            $this->_helper->FlashMessenger('ID do evento não informado');
            return $this->_redirect(BASE_URL .  'admin/timeline');
        }

        $timeline = $this->model->find($id);
        if (!$timeline) {
            $this->_helper->FlashMessenger('Evento não encontrado');
            return $this->_redirect(BASE_URL .  'admin/timeline');
        }

        if ($request->getParam('confirm')) {
            try {
                $this->_deleteImage($timeline->image);
                $this->model->deleteImage($id);

                $this->_helper->FlashMessenger('Imagem removida');
                return $this->_redirect(BASE_URL .  'admin/timeline');
            } catch (Exception $ex) {
                $this->_helper->FlashMessenger($ex->getMessage());
            }
        }

        $this->view->timeline = $timeline;
    }

    public function cropAction()
    {
        $this->view->title .= " - Crop";

        $request = $this->getRequest();
        $id = $request->getParam('id');
        if (!$id) {
            $this->_helper->FlashMessenger('ID do evento não informado');
            return $this->_redirect(BASE_URL .  'admin/timeline');
        }

        $timeline = $this->model->find($id);
        if (!$timeline) {
            $this->_helper->FlashMessenger('Evento não encontrado');
            return $this->_redirect(BASE_URL .  'admin/timeline');
        }

        $form = new Lib_Form_Crop();
        if ($request->isPost()) {
            try {
                if ($form->isValid($_POST)) {
                    $image = $this->_helper->Image->cropImg(UPLOAD_PATH . $_POST['image'], $_POST['w'], $_POST['h'], $_POST['x'], $_POST['y']);

                    $this->_helper->FlashMessenger('Imagem <strong><i>&OpenCurlyDoubleQuote;' . $timeline->title . '&CloseCurlyDoubleQuote;</i></strong> salva');
                    return $this->_redirect(BASE_URL .  'admin/timeline');
                }
            } catch (Exception $ex) {
                $this->_helper->FlashMessenger($ex->getMessage());
            }
        } else {
            $form->populate(array(
                'image' => $timeline->image,
            ));
        }

        $this->view->form = $form;
        $this->view->timeline = $timeline;
    }

}

