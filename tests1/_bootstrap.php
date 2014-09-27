<?php
/*
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

defined('YII_APP_BASE_PATH') or define('YII_APP_BASE_PATH', dirname(dirname(dirname(dirname(__DIR__)))));

defined('YII_BACKEND_TEST_ENTRY_URL') or define('YII_BACKEND_TEST_ENTRY_URL', \Codeception\Configuration::config()['config']['test_entry_url']);
defined('YII_TEST_BACKEND_ENTRY_FILE') or define('YII_TEST_BACKEND_ENTRY_FILE', YII_APP_BASE_PATH . '/backend/web/index-test.php');

require_once(YII_APP_BASE_PATH . '/vendor/autoload.php');
require_once(YII_APP_BASE_PATH . '/vendor/yiisoft/yii2/Yii.php');
require_once(YII_APP_BASE_PATH . '/common/config/bootstrap.php');
require_once(YII_APP_BASE_PATH . '/backend/config/bootstrap.php');

// set correct script paths

// the entry script file path for functional and acceptance tests
$_SERVER['SCRIPT_FILENAME'] = YII_TEST_BACKEND_ENTRY_FILE;
$_SERVER['SCRIPT_NAME'] = YII_BACKEND_TEST_ENTRY_URL;
$_SERVER['SERVER_NAME'] = 'localhost';

Yii::setAlias('@tests', dirname(dirname(__DIR__)));

*/

// the entry script URL (without host info) for functional and acceptance tests
// PLEASE ADJUST IT TO THE ACTUAL ENTRY SCRIPT URL
defined('TEST_ENTRY_URL') or define('TEST_ENTRY_URL', '/basic/web/index-test.php');

// the entry script file path for functional and acceptance tests
defined('TEST_ENTRY_FILE') or define('TEST_ENTRY_FILE', dirname(__DIR__) . '/backend/web/index-test.php');

defined('YII_DEBUG') or define('YII_DEBUG', true);

defined('YII_ENV') or define('YII_ENV', 'test');

require_once(__DIR__ . '/../../../autoload.php');

require_once(__DIR__ . '/../../../yiisoft/yii2/Yii.php');

// set correct script paths
$_SERVER['SCRIPT_FILENAME'] = TEST_ENTRY_FILE;
$_SERVER['SCRIPT_NAME'] = TEST_ENTRY_URL;
$_SERVER['SERVER_NAME'] = 'localhost';

Yii::setAlias('@tests', __DIR__);