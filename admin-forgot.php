<?php

use \Balloonmkt\PageAdmin;
use \Balloonmkt\DB\Sql;
use \Balloonmkt\Model\User;

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

?>
