<?php

require_once("vendor/autoload.php");

use \Balloonmkt\DB\Sql;
use \Balloonmkt\Page;
/*
$sql = new Sql();

$resultado = $sql->select("SELECT * FROM TB_TESTE");

echo json_encode($resultado);
*/

$page = new Page();

$page->setTpl("index");

?>
