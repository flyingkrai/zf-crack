<?php

/**
 * Description of LayoutPlugin
 *
 * @author davi
 */
class Lib_Plugins_LayoutPlugin extends Zend_Controller_Plugin_Abstract
{

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $module = $request->getModuleName();
        switch ($module) {
            case 'front':
                $this->_frontLayout();
                break;
            default :
                $this->_adminLayout();
                break;
        }
    }

    /**
     * Get Zend_View instrance
     * @return Zend_View
     */
    protected function _getView()
    {
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
        if (null === $viewRenderer->view) {
            $viewRenderer->initView();
        }
        return $viewRenderer->view;
    }

    protected function _adminLayout()
    {
        Zend_Layout::getMvcInstance()->setLayout('admin');

        $view = $this->_getView();
        $urlHelper = $view->getHelper('BaseUrl');
        /** @var Zend_View_Helper_BaseUrl $urlHelper */
        $view->headTitle('Admin')->setSeparator(' > ');

        $view->headLink()->appendStylesheet($urlHelper->baseUrl('public/styles/admin/reset.css'), 'screen, projection');
        $view->headLink()->appendStylesheet($urlHelper->baseUrl('public/styles/admin/main.css'), 'screen, projection');
        $view->headLink()->appendStylesheet($urlHelper->baseUrl('public/styles/admin/1col.css'), 'screen, projection');
        $view->headLink()->appendStylesheet($urlHelper->baseUrl('public/styles/admin/main-ie6.css'), 'screen, projection', "lt IE 8");
        $view->headLink()->appendStylesheet($urlHelper->baseUrl('public/styles/admin/style.css'), 'screen, projection');
        $view->headLink()->appendStylesheet($urlHelper->baseUrl('public/styles/admin/mystyle.css'), 'screen, projection');
        $view->headLink()->appendStylesheet($urlHelper->baseUrl('public/styles/smoothness/jquery-ui-1.8.14.custom.css'));
        $view->headLink()->appendStylesheet($urlHelper->baseUrl('public/styles/lightbox/jquery.lightbox-0.5.css'), 'screen');
        $view->headLink()->appendStylesheet($urlHelper->baseUrl('public/styles/jcrop/jquery.Jcrop.css'));

        $view->headScript()->appendFile($urlHelper->baseUrl('public/scripts/jquery-1.6.2.min.js'));
        $view->headScript()->appendFile($urlHelper->baseUrl('public/scripts/jquery-ui-1.8.14.full.min.js'));
        $view->headScript()->appendFile($urlHelper->baseUrl('public/scripts/jquery-ui-timepicker-addon.js'));
        $view->headScript()->appendFile($urlHelper->baseUrl('public/scripts/jquery.tablesorter.min.js'));
        $view->headScript()->appendFile($urlHelper->baseUrl('public/scripts/jquery.tablesorter.pager.min.js'));
        $view->headScript()->appendFile($urlHelper->baseUrl('public/scripts/jquery.lightbox-0.5.min.js'));
        $view->headScript()->appendFile($urlHelper->baseUrl('public/scripts/jquery.Jcrop.min.js'));
        $view->headScript()->appendFile($urlHelper->baseUrl('public/scripts/jquery.color.js'));
    }

    protected function _frontLayout()
    {
        Zend_Layout::getMvcInstance()->setLayout('layout');

        $view = $this->_getView();
        $urlHelper = $view->getHelper('BaseUrl');
        /** @var Zend_View_Helper_BaseUrl $urlHelper */
        $view->headTitle('Crack no Ceará: Uma epidemia | Jangadeiro Online')->setSeparator(' | ');

        $view->headLink()->appendStylesheet($urlHelper->baseUrl('public/styles/front/style.css'));

        $view->headScript()->appendFile($urlHelper->baseUrl('public/scripts/jquery-1.6.2.min.js'));
        //        $view->headScript()->appendFile('/scripts/dd_belatedpng.js');
        //        $view->headScript()->appendFile('/scripts/modernizr-2.0.6.min.js');
    }

}
