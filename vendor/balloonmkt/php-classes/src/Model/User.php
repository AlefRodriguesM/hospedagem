<?php

namespace Balloonmkt\Model;

use \Balloonmkt\Model;
use \Balloonmkt\DB\Sql;

class User extends Model{
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

      $user->setPK_ID($data["PK_ID"]);
    }else{
      throw new \Exception("Usuário inexistente ou senha invállida.");
    }
  }
}

?>
