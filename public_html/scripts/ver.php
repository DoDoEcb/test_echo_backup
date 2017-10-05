<?php
session_start();
//Chamando Classe de Conexção
require_once("Classes/connection/connect.php");
$pdo = new Connection();
$pdo->Connect();

$sql = $pdo->pdo->query("SELECT * FROM financeiro WHERE status!='Ativo'");
$res = $sql->fetchAll(PDO::FETCH_OBJ);
foreach ($res as $row){
echo $row->username."<br>";

}




?>