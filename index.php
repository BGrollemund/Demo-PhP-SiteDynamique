<?php

define( 'DS', DIRECTORY_SEPARATOR);
define( 'ROOT_PATH', dirname( __FILE__ ) . DS );
define( 'APP_PATH', ROOT_PATH . 'app' . DS );

require_once APP_PATH . 'config.php';
require_once APP_PATH . 'database.php';
require_once APP_PATH . 'view.php';
require_once APP_PATH . 'controller.php';
require_once APP_PATH . 'router.php';
require_once APP_PATH . 'app.php';