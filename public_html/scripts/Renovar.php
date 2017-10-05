<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
require_once("Classes/connection/connect.php");
$pdo =new Connection();
$pdo->Connect();

$sql = $pdo->pdo->query("SELECT u.username as usuario,f.saldo as saldo_d,p.price_btc as valor_plano,w.valor_solicitado as valor_saque,f.saldo_mining as saldo_ming FROM usuarios as u INNER JOIN financeiro as f INNER JOIN withdraw as w INNER JOIN plan as p ON u.username=f.username AND w.username=u.username AND f.plan=p.id WHERE f.status='Ativo' AND f.plan!='1' AND f.saldo>=0.0607232 AND w.descricao='withdrawal request' AND w.status!='Reversed'");
$res = $sql->fetchAll(PDO::FETCH_OBJ);
foreach ($res as $row){
      $valor_renovar = $row->valor_plano*2;
    $saldo_ganho = $row->saldo_d+$row->valor_saque+$row->saldo_ming;
    if($saldo_ganho >=$valor_renovar){

      $sql = $pdo->pdo->query("UPDATE financeiro set status='Renovar' where username='$row->usuario'");
    }



}
?>