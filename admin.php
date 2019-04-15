<?php

use \Balloonmkt\PageAdmin;
use \Balloonmkt\DB\Sql;
use \Balloonmkt\Model\User;

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

?>
