<?php
//Setup
require_once('system/action.php');
require_once('system/controller.php');
require_once('system/model.php');
require_once('system/log.php');
require_once('system/document.php');

define('HTTP_SERVER', 'http://example.com/');
define('REWRITE_BASE', '/');
define('DIR_ROOT', '/var/www/html/');
define('URL_ALIAS', '0');

//Set up DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'admin');
define('DB_PASSWORD', 'password');
define('DB_DATABASE', 'database');

//Set up the route
if (URL_ALIAS == '1') {
  //Get SEO URL parts
  $url = $_SERVER['REQUEST_URI'];
  $url = str_replace(REWRITE_BASE, '', $url);
  $url_parts = parse_url($url);
  
  //Get parameters from URL
  if (isset($url_parts['query']) && $url_parts['query'] != '') {
    parse_str($url_parts['query'], $args);
  } else {
    $args = '';
  }
  
  $keyword = $url_parts['path'];
  
  //Set up the document
  $document = new Document();
  
  //Load model to check url alias
  $url_model = $document->loadModel('common/url');
  
  //Call lookup method for url alias
  $url_data = $url_model->getKeyword($keyword);
  
  //Set variables for Document
  if (isset($url_data['keyword']) && isset($url_data['query'])) {
    $document->url_query = $url_data['query'];
    $document->url_id = $url_data['parameter'];
  } else {
    $document->url_query = 'error/error';
    $document->url_id = '';
  }
  
  //Setup the route with the value from db
  $action = new Action($url_data['query']);
  
  require_once($action->getFile());
  
} else {
  //If no vanity url get the route and load it
  if (isset($_GET['route'])) {
    $action = new Action($_GET['route']);
  } else {
    $action = new Action('common/home');
  }
  
  require_once($action->getFile());
  
  //Set up the document
  $document = new Document();
}

//Get the class and set up the controller
$class = $action->getClass();
$controller = new $class($document);

//Output Results
echo $controller->{$action->getMethod()}($action->getArgs());

//Set up the error log
$log = new Log('error.txt');
?>