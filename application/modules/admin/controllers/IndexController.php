<?php

class Admin_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->title = "Dashboard";
        $this->view->headTitle($this->view->title);
    }

    /**
     * @param array $values
     * @return bool
     *
     *
     */
    protected function _process($values)
    {
        // Get our authentication adapter and check credentials
        $adapter = $this->_getAuthAdapter();
        $adapter->setIdentity($values['username']);
        $adapter->setCredential($values['password']);

        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($adapter);
        if ($result->isValid()) {
            $user = $adapter->getResultRowObject();
            $auth->getStorage()->write($user);
            return true;
        }
        return false;
    }

    /**
     * @return Zend_Auth_Adapter_DbTable
     *
     *
     */
    protected function _getAuthAdapter()
    {
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

        $authAdapter->setTableName('users')
                ->setIdentityColumn('username')
                ->setCredentialColumn('password')
                ->setCredentialTreatment('SHA1(CONCAT(?,salt))');


        return $authAdapter;
    }

    protected function _hasAuth()
    {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('admin/dashboard');
        }
    }

    /**
     * @param array $data
     *
     */
    protected function _generateOpenGraph($data)
    {
        $html = <<<HTML
<meta property="og:title" content="{title}"/>
<meta property="og:type" content="{type}"/>
<meta property="og:url" content="{url}"/>
<meta property="og:image" content="{image}"/>
<meta property="og:site_name" content="{siteName}"/>
<meta property="og:description" content="{description}"/>
HTML;

        foreach ($data as $key => $value) {
            $html = str_replace('{' . $key . '}', $value, $html);
        }

        @file_put_contents(APPLICATION_PATH . '/layouts/scripts/front/_opengraph.phtml', $html);
    }

    public function indexAction()
    {
    }

    public function loginAction()
    {
        $this->view->headTitle('Login');
        $this->_helper->layout()->setLayout('login');

        $this->_hasAuth();
        $request = $this->getRequest();

        $form = new Lib_Form_Login();
        if ($request->isPost()) {
            if ($form->isValid($_POST)) {
                if ($this->_process($form->getValues())) {
                    // We're authenticated! Redirect to the home page
                    $this->_redirect('admin/dashboard');
                }
            }
        }
        $this->view->form = $form;
    }

    public function logoutAction()
    {
        @Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('admin/');
    }

    public function opengraphAction()
    {
        $this->view->title .= " - Facebook OpenGraph";

        $form = new Lib_Form_OpenGraph();
        $configModel = new Application_Model_Config();
        $openGraph = $configModel->findAll('opengraph');

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                try {
                    $configModel->save('opengraph', $_POST);
                    $this->_generateOpenGraph($_POST);

                    $this->_helper->FlashMessenger('Open Graph Atualizado');
                    $this->_redirect('admin/dashboard');
                } catch (Exception $ex) {
                    $this->_helper->FlashMessenger($ex->getMessage());
                }
            }
        } else {
            $form->populate(array(
                'title' => $openGraph->title,
                'type' => $openGraph->type,
                'url' => $openGraph->url,
                'image' => $openGraph->image,
                'siteName' => $openGraph->siteName,
                'description' => $openGraph->description,
            ));
        }

        $this->view->form = $form;
    }

}

