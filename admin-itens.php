<?php

use \Balloonmkt\PageAdmin;
use \Balloonmkt\DB\Sql;
use \Balloonmkt\Model\User;
use \Balloonmkt\Model\Item;

$app->get('/admin/itens', function(){
  User::verifyLogin();

  $user = new User();
  $item = new Item();

  $user->get((int)$_SESSION[User::SESSION]["PK_ID"]);

  $page = new PageAdmin(array("data"=>$user->getValues()));

  $itens = Item::listAll();

  $page->setTpl('itens', array('itens'=>$itens));
});

$app->get('/admin/itens/create', function(){
  User::verifyLogin();

  $user = new User();

  $user->get((int)$_SESSION[User::SESSION]["PK_ID"]);

  $page = new PageAdmin(array("data"=>$user->getValues()));

  $page->setTpl('itens-create');
});

$app->get('/admin/itens/:PK_ID/delete', function($PK_ID){
  User::verifyLogin();

  $item = new Item();

  $item->get((int)$PK_ID);

  $item->delete();

  header('Location: /admin/itens');

  exit;
});

$app->get('/admin/itens/:PK_ID', function($PK_ID){
  User::verifyLogin();

  $user = new User();
  $item = new Item();

  $user->get((int)$_SESSION[User::SESSION]["PK_ID"]);
  $item->get((int)$PK_ID);

  $page = new PageAdmin(array("data"=>$user->getValues()));

  $page->setTpl('itens-update', array("item"=>$item->getValues()));
});

$app->post('/admin/itens/create', function(){
  User::verifyLogin();

  $item = new Item();

  $item->setData($_POST);

  $item->save();

  header('Location: /admin/itens');

  exit;
});

$app->post('/admin/itens/:PK_ID', function($PK_ID){
  User::verifyLogin();

  $item = new Item();

  $item->get((int)$PK_ID);

  $item->setData($_POST);

  $item->update();

  header('Location: /admin/itens');

  exit;
});

?>
