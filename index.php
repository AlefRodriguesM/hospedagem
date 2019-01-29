<?php

require_once("vendor/autoload.php");

use \Slim\Slim;
use \Balloonmkt\DB\Sql;
use \Balloonmkt\Page;
use \Balloonmkt\PageAdmin;

$get = function($nomeArquivo){
  $page = new Page();

  $page->setTpl($nomeArquivo);
};

$getAdmin = function($nomeArquivo){
  $page = new PageAdmin();

  $page->setTpl($nomeArquivo);
};

$app = new Slim();

$app->config('debug', true);

$app->get('/', $get('index'));

$app->get('/admin', $getAdmin('index'));

?>
