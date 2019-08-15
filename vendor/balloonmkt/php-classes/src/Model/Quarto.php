<?php

namespace Balloonmkt\Model;

use \Balloonmkt\Model;
use \Balloonmkt\DB\Sql;
use \Balloonmkt\Mailer;

class Quarto extends Model{
  public static function listAll(){
    $sql = new Sql();

    return $sql->select("SELECT * FROM TB_QUARTOS");
  }

  public function save(){
    $sql = new Sql();

    $results = $sql->select("CALL SP_QUARTOS_SALVAR(:DS_NOME, :DS_DESCRICAO)", array(
      ":DS_NOME"=>$this->getDS_NOME(),
      ":DS_DESCRICAO"=>$this->getDS_DESCRICAO()
    ));

    $this->setData($results[0]);
  }

  public function get($PK_ID){
    $sql = new Sql();

    $results = $sql->select("SELECT * FROM TB_QUARTOS WHERE PK_ID = :PK_ID", array(
        ":PK_ID"=>$PK_ID
    ));

    $this->setData($results[0]);
  }

  public function update(){
    $sql = new Sql();

    $results = $sql->select("CALL SP_QUARTOS_ATUALIZAR(:PK_ID, :DS_NOME, :DS_DESCRICAO)", array(
      ":PK_ID"=>$this->getPK_ID(),
      ":DS_NOME"=>$this->getDS_NOME(),
      ":DS_DESCRICAO"=>$this->getDS_DESCRICAO()
    ));

    $this->setData($results[0]);
  }

  public function delete(){
    $sql = new sql();

    $sql->executa("CALL SP_QUARTOS_DELETAR(:PK_ID)", array(
      ":PK_ID"=>$this->getPK_ID()
    ));
  }

  public function checkPhoto(){
    if(file_exists(
      $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .
      'res' . DIRECTORY_SEPARATOR .
      'admin' . DIRECTORY_SEPARATOR .
      'img' . DIRECTORY_SEPARATOR .
      'quartos' . DIRECTORY_SEPARATOR .
      $this->getPK_ID() . '.jpg'
    )){
      $url = '/res/admin/img/quartos/' . $this->getPK_ID() . '.jpg';
    }else{
      $url = '/res/admin/img/itens/default.jpg';
    };

    return $this->setDS_FOTO($url);
  }

  public function getValues(){
    $this->checkPhoto();

    $values = parent::getValues();

    return $values;
  }

  public function setPhoto($file){
    $extension = explode('.', $file['name']);

    $extension = end($extension);

    $dir = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .
      'res' . DIRECTORY_SEPARATOR .
      'admin' . DIRECTORY_SEPARATOR .
      'img' . DIRECTORY_SEPARATOR .
      'quartos' . DIRECTORY_SEPARATOR .
      $this->getPK_ID();

    switch($extension){
      case 'jpg':
      case 'jpeg':
      $image = imagecreatefromjpeg($file['tmp_name']);
      $dir = $dir . '.jpg';
      imagejpeg($image, $dir);
      break;

      case 'gif';
      $image = imagecreatefromgif($file['tmp_name']);
      $dir = $dir . '.gif';
      imagegif($image, $dir);
      break;

      case 'png';
      $image = imagecreatefrompng($file['tmp_name']);
      $dir = $dir . '.png';
      imagepng($image, $dir);
      break;
    }

    imagedestroy($image);

    $this->checkPhoto();
  }
}

?>
