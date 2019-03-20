<?php

namespace Balloonmkt\Model;

use \Balloonmkt\Model;
use \Balloonmkt\DB\Sql;

class User extends Model{
  const SESSION = "User";

  public static function login($login, $password){
    $sql = new Sql();

    $results = $sql->select("SELECT * FROM TB_USERS WHERE DS_LOGIN = :LOGIN", array(
      ":LOGIN"=>$login
    ));

    if(count($results) === 0){
      throw new \Exception("Usuário inexistente ou senha invállida.");
    }

    $data = $results[0];

    if(password_verify($password, $data["DS_PASSWORD"]) === true){
      $user = new User();

      $user->setData($data);

      $_SESSION[User::SESSION] = $user->getValues();

      return $user;
    }else{
      throw new \Exception("Usuário inexistente ou senha invállida.");
    }
  }

  public static function verifyLogin($TG_ADMIN = true){
    if(!isset($_SESSION[User::SESSION])
      || !$_SESSION[User::SESSION]
      || !(int)$_SESSION[User::SESSION]["PK_ID"] > 0
      || (bool)$_SESSION[User::SESSION]["TG_ADMIN"] !== $TG_ADMIN
    ){
      header("Location: /admin/login");
      exit;
    }
  }

  public static function logout(){
    $_SESSION[User::SESSION] = NULL;
  }

  public static function listAll(){
    $sql = new Sql();

    return $sql->select("SELECT * FROM tb_users");
  }

  public function save(){
    $sql = new Sql();

    $results = $sql->select("CALL sp_users_save(:DS_LOGIN, :DS_PASSWORD, :DS_EMAIL, :TG_ADMIN)", array(
      ":DS_LOGIN"=>$this->getDS_LOGIN(),
      ":DS_PASSWORD"=>$this->getDS_PASSWORD(),
      ":DS_EMAIL"=>$this->getDS_EMAIL(),
      ":TG_ADMIN"=>$this->getTG_ADMIN()
    ));

    $this->setData($results[0]);
  }

  public function get($PK_ID){
    $sql = new Sql();

    $results = $sql->select("SELECT * FROM tb_users WHERE PK_ID = :PK_ID", array(
        ":PK_ID"=>$PK_ID
    ));

    $this->setData($results[0]);
  }

  public function update(){
    $sql = new Sql();

    $results = $sql->select("CALL sp_usersupdate_save(:PK_ID, :DS_LOGIN, :DS_EMAIL, :TG_ADMIN)", array(
      ":PK_ID"=>$this->getPK_ID(),
      ":DS_LOGIN"=>$this->getDS_LOGIN(),
      ":DS_EMAIL"=>$this->getDS_EMAIL(),
      ":TG_ADMIN"=>$this->getTG_ADMIN()
    ));

    $this->setData($results[0]);
  }

  public function delete(){
    $sql = new sql();

    $sql->executa("CALL sp_users_delete(:PK_ID)", array(
      ":PK_ID"=>$this->getPK_ID()
    ));
  }

  public static function getForgot($email){
    $sql = new Sql();

    $results = $sql->select("
      SELECT
        PK_ID
      FROM tb_users
      WHERE
        DS_EMAIL = :EMAIL
    ", array(
        ":DS_EMAIL"=>$email
    ));

    if (count($results) === 0){
      throw new \Exception("Não foi possível recuperar a senha.");
    }else{
      $results2 = $sql->select("CALL SP_USERSPASSRECORVER_CREATE(:PK_ID, :DS_IP)", array(
        ":PK_ID"=>$data["PK_ID"],
        ":DS_IP"=>$SERVER["REMOTE_ADDR"]
      ));

      if (count($results2) === 0){
        throw new \Exception("Não foi possível recuperar a senha.")
      }else{
        $dataRecovery = $results2[0];
      }
    }
  }
}

?>
