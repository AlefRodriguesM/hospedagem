<?php
//PHP Version 5.6.38
//var_dump();
//json_encode();
session_start();
require_once('vendor/autoload.php');

use \Slim\Slim;
use \Balloonmkt\DB\Sql;
use \Balloonmkt\Page;
use \Balloonmkt\PageAdmin;
use \Balloonmkt\Model\User;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function(){
  $page = new Page();

  $page->setTpl('index');
});

$app->get('/admin', function(){
  User::verifyLogin();

  $user = new User();

  $user->get((int)$_SESSION[User::SESSION]["PK_ID"]);

  $page = new PageAdmin(array("data"=>$user->getValues()));

  $page->setTpl('index', array("user"=>$user->getValues()));
});

$app->get('/admin/login', function(){
  $page = new PageAdmin([
    'header'=>false,
    'footer'=>false
  ]);

  $page->setTpl('login');
});

$app->post('/admin/login', function(){
  User::login($_POST['login'], $_POST['password']);

  header('Location: /admin');

  exit;
});

$app->get('/admin/logout', function(){
  User::logout();

  header('Location: /admin/login');

  exit;
});

$app->get('/admin/users', function(){
  User::verifyLogin();

  $users = User::listAll();

  $page = new PageAdmin();

  $page->setTpl('users', array('users'=>$users));
});

$app->get('/admin/users/create', function(){
  User::verifyLogin();

  $page = new PageAdmin();

  $page->setTpl('users-create');
});

$app->get('/admin/users/:PK_ID/delete', function($PK_ID){
  User::verifyLogin();

  $user = new User();

  $user->get((int)$PK_ID);

  $user->delete();

  header('Location: /admin/users');

  exit;
});

$app->get('/admin/users/:PK_ID', function($PK_ID){
  User::verifyLogin();

  $user = new User();

  $user->get((int)$PK_ID);

  $page = new PageAdmin();

  $page->setTpl('users-update', array("user"=>$user->getValues()));
});

$app->post('/admin/users/create', function(){
  User::verifyLogin();

  $user = new User();

  $_POST['TG_ADMIN'] = (isset($_POST['TG_ADMIN']))?1:0;

  $_POST['DS_PASSWORD'] = password_hash($_POST['DS_PASSWORD'], PASSWORD_DEFAULT, [
 		"cost"=>12
 	]);

  $user->setData($_POST);

  $user->save();

  header('Location: /admin/users');

  exit;
});

$app->post('/admin/users/:PK_ID', function($PK_ID){
  User::verifyLogin();

  $user = new User();

  $_POST['TG_ADMIN'] = (isset($_POST['TG_ADMIN']))?1:0;

  $user->get((int)$PK_ID);

  $user->setData($_POST);

  $user->update();

  header('Location: /admin/users');

  exit;
});

$app->get('/admin/forgot', function(){
  $page = new PageAdmin([
    'header'=>false,
    'footer'=>false
  ]);

  $page->setTpl('forgot');
});

$app->post('/admin/forgot', function(){
  $user = User::getForgot($_POST['email']);

  header('Location: /admin/forgot/sent');

  exit;
});

$app->get('/admin/forgot/sent',function(){
  $page = new PageAdmin([
    'header'=>false,
    'footer'=>false
  ]);

  $page->setTpl('forgot-sent');
});

$app->get('/admin/forgot/reset', function(){
  $user = User::validForgotDecrypt($_GET["code"]);

  $page = new PageAdmin([
    'header'=>false,
    'footer'=>false
  ]);

  $page->setTpl('forgot-reset', array(
    'name'=>$user['DS_LOGIN'],
    'code'=>$_GET['code']
  ));
});

$app->post('/admin/forgot/reset', function(){
  $forgot = User::validForgotDecrypt($_POST["code"]);

  User::setForgotUsed($forgot['FK_RECOVERY']);

  $user = new User();

  $user->get((int)$forgot['PK_ID']);

  $password = password_hash($_POST['DS_PASSWORD'], PASSWORD_DEFAULT, [
 		"cost"=>12
 	]);

  $user->setPassword($password);

  $page = new PageAdmin([
    'header'=>false,
    'footer'=>false
  ]);

  $page->setTpl('forgot-reset-success');

  exit;
});

$app->run();

?>
