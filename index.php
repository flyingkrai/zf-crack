<?php

// Define base url fix
defined('BASE_URL_FIX')
        || define('BASE_URL_FIX', '/');

// Define base url
defined('BASE_URL')
        || define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . BASE_URL_FIX);

// Define url to upload directory
defined('UPLOAD_URL')
        || define('UPLOAD_URL', BASE_URL . 'public/upload');

// Define path to upload directory
defined('UPLOAD_PATH')
        || define('UPLOAD_PATH', realpath(dirname(__FILE__) . '/public/upload'));

// Define path to application directory
defined('APPLICATION_PATH')
        || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));

// Define application environment
defined('APPLICATION_ENV')
        || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
            realpath(APPLICATION_PATH . '/../library'),
            get_include_path(),
        )));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
                APPLICATION_ENV,
                APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
        ->run();
