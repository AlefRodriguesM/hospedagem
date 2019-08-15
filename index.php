<?php
//PHP Version 5.6.38
//var_dump();
//json_encode();
session_start();
require_once('vendor/autoload.php');

use \Slim\Slim;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function(){
  $page = new Page();

  $page->setTpl('index');
});

require_once('admin.php');
require_once('admin-forgot.php');
require_once('admin-users.php');
require_once('admin-itens.php');
require_once('admin-quartos.php');

$app->run();

?>
