<?php
//Setup
require_once('system/action.php');
require_once('system/controller.php');
require_once('system/model.php');
require_once('system/db.php');
require_once('system/log.php');
require_once('system/document.php');

define('HTTP_SERVER', 'www.example.com');
define('DIR_ROOT', '/var/www/html/example/');

//Set up DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'username');
define('DB_PASSWORD', 'password');
define('DB_DATABASE', 'database');

//Uncomment to use a database
//$db = new Db(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

//Route
if (isset($_GET['route'])) {
	$action = new Action($_GET['route']);
} else {
	$action = new Action('common/home');
}
require_once($action->getFile());

//Set up the document
$document = new Document();

//Get the class and set up the controller
$class = $action->getClass();
$controller = new $class($document);

//Output Results
echo $controller->{$action->getMethod()}($action->getArgs());

//Set up the error log
$log = new Log('error.txt');
?>