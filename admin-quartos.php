<?php

use \Balloonmkt\PageAdmin;
use \Balloonmkt\DB\Sql;
use \Balloonmkt\Model\User;
use \Balloonmkt\Model\Quarto;

$app->get('/admin/quartos', function(){
  User::verifyLogin();

  $user = new User();
  $quarto = new Quarto();

  $user->get((int)$_SESSION[User::SESSION]["PK_ID"]);

  $page = new PageAdmin(array("data"=>$user->getValues()));

  $quartos = Quarto::listAll();

  $page->setTpl('quartos', array('quartos'=>$quartos));
});

$app->get('/admin/quartos/create', function(){
  User::verifyLogin();

  $user = new User();

  $user->get((int)$_SESSION[User::SESSION]["PK_ID"]);

  $page = new PageAdmin(array("data"=>$user->getValues()));

  $page->setTpl('quartos-create');
});

$app->post('/admin/quartos/create', function(){
  User::verifyLogin();

  $quarto = new Quarto();

  $quarto->setData($_POST);

  $quarto->save();

  if($_FILES["file"]["name"] !== ""){
    $quarto->setPhoto($_FILES['file']);
  }

  header('Location: /admin/quartos');

  exit;
});

$app->get('/admin/quartos/:PK_ID', function($PK_ID){
  User::verifyLogin();

  $user = new User();
  $quarto = new Quarto();

  $user->get((int)$_SESSION[User::SESSION]["PK_ID"]);
  $quarto->get((int)$PK_ID);

  $page = new PageAdmin(array("data"=>$user->getValues()));

  $page->setTpl('quartos-update', array("quarto"=>$quarto->getValues()));
});

$app->post('/admin/quartos/:PK_ID', function($PK_ID){
  User::verifyLogin();

  $quarto = new Quarto();

  $quarto->get((int)$PK_ID);

  $quarto->setData($_POST);

  $quarto->update();

  if($_FILES["file"]["name"] !== ""){
    $quarto->setPhoto($_FILES["file"]);
  }

  header('Location: /admin/quartos');

  exit;
});

$app->get('/admin/quartos/:PK_ID/delete', function($PK_ID){
  User::verifyLogin();

  $quarto = new Quarto();

  $quarto->get((int)$PK_ID);

  $quarto->delete();

  header('Location: /admin/quartos');

  exit;
});

?>
