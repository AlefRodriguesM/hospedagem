<?php

require_once("vendor/autoload.php");

$sql = new Balloonmkt\DB\Sql();

$resultado = $sql->select("SELECT * FROM TB_TESTE");

echo json_encode($resultado);

?>
