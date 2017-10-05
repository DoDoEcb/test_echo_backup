<?php

session_start();
//Chamando Classe de Conexção
require_once("Classes/connection/connect.php");
$pdo =new Connection();
$pdo->Connect();

$data = date("Y-m-d");
$sql = $pdo->pdo->query("SELECT saldo_mining,username,personal_id,plan FROM financeiro ");
$res = $sql->fetchAll(PDO::FETCH_OBJ);
foreach ($res as $row){

    $sql = $pdo->pdo->query("UPDATE financeiro SET saldo=saldo+'$row->saldo_mining',saldo_mining='0' WHERE username='$row->username'");
    $sql = $pdo->pdo->query("INSERT INTO extrato (personal_id,username,descricao,data,valor,status) VALUES('$row->personal_id','$row->username','Ganho de mineracao diaria','$data','$row->saldo_mining','Payd')");

}



?>