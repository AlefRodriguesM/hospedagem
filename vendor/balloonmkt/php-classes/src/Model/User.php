<?php

namespace Balloonmkt\Model;

use \Balloonmkt\Model;
use \Balloonmkt\DB\Sql;
use \Balloonmkt\Mailer;

class User extends Model{
  const SESSION = "User";
  const SECRET = "Balloonhosp_Secret";

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

  public static function getForgot($email, $inadmin = true){
    $sql = new Sql();

    $results = $sql->select("
      SELECT
        *
      FROM tb_users
      WHERE
        DS_EMAIL = :DS_EMAIL
    ", array(
        ":DS_EMAIL"=>$email
    ));

    if (count($results) === 0){
      throw new \Exception("Não foi possível recuperar a senha.");
    }else{
      $data = $results[0];
      //echo json_encode($_SERVER["REMOTE_ADDR"]);
      //exit;
      $results2 = $sql->select("CALL SP_USERSPASSRECOVER_CREATE(:FK_USUARIO, :DS_IP)", array(
        ":FK_USUARIO"=>$data["PK_ID"],
        ":DS_IP"=>$_SERVER["REMOTE_ADDR"]
      ));

      if (count($results2) === 0){
        throw new \Exception("Não foi possível recuperar a senha.");
      }else{
        $dataRecovery = $results2[0];

        //$iv = random_bytes(openssl_cipher_iv_length('aes-256-cbc'));

        //$code = openssl_encrypt($dataRecovery['PK_ID'], 'aes-256-cbc', User::SECRET, 0, $iv);

        //$result = base64_encode($iv.$code);

        $result = base64_encode($dataRecovery['PK_ID']);

        if($inadmin === true){
          $link = "http://www.hospedagem.com.br/admin/forgot/reset?code=$result";
        }else{
          $link = "http://www.hospedagem.com.br/forgot/reset?code=$result";
        }

        $mailer = new Mailer($data['DS_EMAIL'], $data['DS_LOGIN'], 'Redefinir senha da Ballon Hosp.', 'forgot',
          array(
            'name'=>$data['DS_LOGIN'],
            'link'=>$link
        ));

        $mailer->send();

        return $data;
      }
    }
  }

  public static function validForgotDecrypt($result){
    $FK_RECOVERY = base64_decode($result);

    $sql = new Sql();

    $results = $sql->select("
      SELECT
        a.PK_ID AS FK_RECOVERY,
        a.*,
        b.*
      FROM TB_USERSPASSRECOVER a
      INNER JOIN tb_users b ON B.PK_ID = A.FK_USUARIO
      WHERE
          a.PK_ID = :FK_RECOVERY
      AND a.DT_RECUPERACAO IS NULL
      AND DATE_ADD(a.DT_INCLUSAO, INTERVAL 1 HOUR) >= NOW();
     ", array(
         ":FK_RECOVERY"=>$FK_RECOVERY
     ));

     if (count($results) === 0)
     {
         throw new \Exception("Não foi possível recuperar a senha.");
     }
     else
     {
         return $results[0];
     }
 }

 public static function setForgotUsed($FK_RECOVERY){
   $sql = new Sql();

   $sql->executa("UPDATE TB_USERSPASSRECOVER SET DT_RECUPERACAO = NOW() WHERE PK_ID = :FK_RECOVERY", array(
     ":FK_RECOVERY"=>$FK_RECOVERY
   ));
 }

 public function setPassword($password){
   $sql = new Sql();

   $sql->executa("UPDATE TB_USERS SET DS_PASSWORD = :DS_PASSWORD WHERE PK_ID = :PK_ID", array(
     ":DS_PASSWORD"=>$password,
     ":PK_ID"=>$this->getPK_ID()
   ));
 }
}

?>
