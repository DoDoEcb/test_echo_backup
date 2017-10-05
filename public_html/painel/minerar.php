<?php
session_start();
//Chamando Classe de Conexção
require_once("../scripts/Classes/connection/connect.php");
function currency($icoin2, $icoin1, $value=1) {
    $coin1 = strtoupper($icoin1);
    $coin2 = strtoupper($icoin2);
    $coin1 = preg_replace("/[^A-Z{3}]/", null, $coin1);
    $coin2 = preg_replace("/[^A-Z{3}]/", null, $coin2);
    $currency = "'BRLBTC=X',0.00011,'4/20/2017','0:44am',0.00011,0.00011";
    $currency = explode(",", $currency);
    $value = (float)($currency[1]*$value);
    return $value;
}

$pdo =new Connection();
$pdo->Connect();

$sql = $pdo->pdo->query("SELECT * FROM financeiro Where username='$_SESSION[username]'");
$res =  $sql->fetch(PDO::FETCH_OBJ);
$saldo_mining_real =  currency('BTC', 'BRL', $res->saldo_mining);
?>
<div class="card">
    <div class="card-content pink lighten-1 white-text">
        <p class="card-stats-title"><i class="fa fa-money"></i> Saldo em Mineração</p>
        <h4 class="card-stats-number">BTC <?php echo number_format($res->saldo_mining,8,".",".") ?></h4>
        <br>
            <br>
    </div>
    <div class="card-action  pink darken-2">
        <div id="invoice-line" class="center-align"></div>
    </div>
</div>

