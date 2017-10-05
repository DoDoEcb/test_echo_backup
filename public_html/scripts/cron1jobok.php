<?php

session_start();
//Chamando Classe de Conexção
require_once("Classes/connection/connect.php");
$pdo =new Connection();
$pdo->Connect();



$sql = $pdo->pdo->query("SELECT p.mining_min,f.username,p.price_btc FROM financeiro as f INNER JOIN plan as p ON f.plan=p.id WHERE f.status='Ativo'");
$res = $sql->fetchAll(PDO::FETCH_OBJ);
foreach ($res as $row){
    $divisao = $row->price_btc*2.88/100;


    $sql = $pdo->pdo->query("UPDATE financeiro SET saldo_mining=saldo_mining+'$divisao' WHERE username='$row->username'");

}




?>