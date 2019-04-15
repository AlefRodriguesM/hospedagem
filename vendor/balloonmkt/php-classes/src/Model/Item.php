<?php

namespace Balloonmkt\Model;

use \Balloonmkt\Model;
use \Balloonmkt\DB\Sql;
use \Balloonmkt\Mailer;

class Item extends Model{
  public function save(){
    $sql = new Sql();

    $results = $sql->select("CALL sp_itens_save(:DS_NOME, :DS_DESCRICAO)", array(
      ":DS_NOME"=>$this->getDS_NOME(),
      ":DS_DESCRICAO"=>$this->getDS_DESCRICAO()
    ));

    $this->setData($results[0]);
  }

  public function get($PK_ID){
    $sql = new Sql();

    $results = $sql->select("SELECT * FROM TB_ITENS WHERE PK_ID = :PK_ID", array(
        ":PK_ID"=>$PK_ID
    ));

    $this->setData($results[0]);
  }

  public function update(){
    $sql = new Sql();

    $results = $sql->select("CALL sp_itensupdate_save(:PK_ID, :DS_NOME, :DS_DESCRICAO)", array(
      ":PK_ID"=>$this->getPK_ID(),
      ":DS_NOME"=>$this->getDS_NOME(),
      ":DS_DESCRICAO"=>$this->getDS_DESCRICAO()
    ));

    $this->setData($results[0]);
  }

  public function delete(){
    $sql = new sql();

    $sql->executa("CALL sp_itens_delete(:PK_ID)", array(
      ":PK_ID"=>$this->getPK_ID()
    ));
  }
}

?>
