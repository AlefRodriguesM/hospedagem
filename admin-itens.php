<?php
-- PAREI MODIFICANDO AQUI
use \Balloonmkt\PageAdmin;
use \Balloonmkt\DB\Sql;
use \Balloonmkt\Model\Item;

$app->get('/admin/itens', function(){
  User::verifyLogin();

  $user = new Item();

  $user->get((int)$_SESSION[User::SESSION]["PK_ID"]);

  $page = new PageAdmin(array("data"=>$user->getValues()));

  $users = User::listAll();

  $page->setTpl('itens', array('users'=>$users));
});

$app->get('/admin/users/create', function(){
  User::verifyLogin();

  $user = new User();

  $user->get((int)$_SESSION[User::SESSION]["PK_ID"]);

  $page = new PageAdmin(array("data"=>$user->getValues()));

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

  $page = new PageAdmin(array("data"=>$user->getValues()));

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

?>
