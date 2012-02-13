<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initAutoLoader()
    {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('Lib');

        return $autoloader;
    }

    protected function _initActionHelpers()
    {
        Zend_Controller_Action_HelperBroker::addHelper(
                new Lib_Action_Helper_Messenger()
        );
        Zend_Controller_Action_HelperBroker::addHelper(
                new Lib_Action_Helper_FileUpload()
        );
        Zend_Controller_Action_HelperBroker::addHelper(
                new Lib_Action_Helper_Image()
        );
        Zend_Controller_Action_HelperBroker::addHelper(
                new Lib_Action_Helper_Auth()
        );
    }

    protected function _initViewHelpers()
    {
        $dateHelper = new Lib_View_Helper_Date();
        $textHelper = new Lib_View_Helper_Text();
        $imageHelper = new Lib_Extra_Image();
        $logHelper = new Lib_View_Helper_Log();

        $this->bootstrap('view');
        $view = $this->getResource('view');

        $view->addHelperPath('Lib/View/Helper/');
        $view->addHelperPath('Lib/Extra/Image/');

        $view->registerHelper($dateHelper, 'dateToBr');
        $view->registerHelper($dateHelper, 'timelineDate');
        $view->registerHelper($textHelper, 'truncate');
        $view->registerHelper($textHelper, 'dbActions');
        $view->registerHelper($imageHelper, 'resizeImage');
        $view->registerHelper($logHelper, 'dumpLogData');
    }

    protected function _initPlugins()
    {
        $front = Zend_Controller_Front::getInstance();

        $front->registerPlugin(
                new Lib_Plugins_AclPlugin()
        );
        $front->registerPlugin(
                new Lib_Plugins_LayoutPlugin()
        );
    }

    protected function _initRoutes()
    {

        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();


        $route = new Zend_Controller_Router_Route(
                        BASE_URL_FIX . ':page',
                        array(
                            'module' => 'front',
                            'controller' => 'Page',
                            'action' => 'index'
                        )
        );
        $router->addRoute('frontend', $route);

        $route = new Zend_Controller_Router_Route(
                        BASE_URL_FIX . 'generate',
                        array(
                            'module' => 'front',
                            'controller' => 'Page',
                            'action' => 'generate'
                        )
        );
        $router->addRoute('generate', $route);

        $route = new Zend_Controller_Router_Route(
                        BASE_URL_FIX . 'admin/:module/:action/*',
                        array(
                            'controller' => 'Index',
                            'action' => 'index'
                        )
        );
        $router->addRoute('admin', $route);

        $route = new Zend_Controller_Router_Route(
                        BASE_URL_FIX . 'admin/dashboard',
                        array(
                            'module' => 'admin',
                            'controller' => 'Index',
                            'action' => 'index'
                        )
        );
        $router->addRoute('adminDashboard', $route);

        $route = new Zend_Controller_Router_Route(
                        BASE_URL_FIX . 'admin/dashboard/:action/*',
                        array(
                            'module' => 'admin',
                            'controller' => 'Index',
                            'action' => 'index'
                        )
        );
        $router->addRoute('dashboard', $route);

        $route = new Zend_Controller_Router_Route(
                        BASE_URL_FIX . 'admin',
                        array(
                            'module' => 'admin',
                            'controller' => 'Index',
                            'action' => 'login'
                        )
        );
        $router->addRoute('adminIndex', $route);

        return $router;
    }

    protected function _initMetadataCache()
    {
        $frontendOptions = array('automatic_serialization' => true);
        $backendOptions = array('cache_dir' => APPLICATION_PATH . '/../cache');

        $factory = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
        Zend_Db_Table_Abstract::setDefaultMetadataCache($factory);
    }

    protected function _initZFDebug()
    {
        $zfdebugConfig = $this->getOption('zfdebug');
        if ($zfdebugConfig['enabled'] != 1)
            return;

        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('ZFDebug');

        $options = array(
//            'jquery_path' => '/scripts/jquery-1.6.2.min.js',
            'plugins' => array('Variables',
                'File' => array('basePath' => '/'),
                'Memory',
                'Time',
                'Registry',
                'Exception')
        );

        # Instantiate the database adapter and setup the plugin.
        # Alternatively just add the plugin like above and rely on the autodiscovery feature.
        if ($this->hasPluginResource('db')) {
            $this->bootstrap('db');
            $db = $this->getPluginResource('db')->getDbAdapter();
            $options['plugins']['Database']['adapter'] = $db;
        }

        # Setup the cache plugin
        if ($this->hasPluginResource('cache')) {
            $this->bootstrap('cache');
            $cache = $this - getPluginResource('cache')->getDbAdapter();
            $options['plugins']['Cache']['backend'] = $cache->getBackend();
        }

        $debug = new ZFDebug_Controller_Plugin_Debug($options);

        $this->bootstrap('frontController');
        $frontController = $this->getResource('frontController');
        $frontController->registerPlugin($debug);
    }

}

