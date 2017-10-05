<?php
ini_set('display_errors', 0);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
session_start(); // start a sessao para este usuario
$userLog = $_SESSION['username']; // Pegando sessao de usuario logado
$passLog = $_SESSION['password']; // Pegando senha de usuario Logado

//Verifica se tem sessao startada.
if(!isset($userLog) AND !isset($passLog)){
    ?>
    <script>window.location='../login.php'</script>
<?php
}

//Chamando Classe de Conexção
require_once("../scripts/Classes/connection/connect.php");
$pdo =new Connection();
$pdo->Connect();

//Logicas Gerais do sistema
require_once("../scripts/Classes/UserInfo.php");
require_once("../scripts/Classes/Binario.php");
require_once("../scripts/Classes/API/lib/block_io.php");
$apiKey = '5a6c-50f7-063a-0d52';
$pin = '32953989';
$version = 2; // the API version
$block_io = new BlockIo($apiKey, $pin, $version);


$Binario = new Binario();
$User = new UserInfo();
$row = $User->BuscarTudo($userLog); // Busca todas as informações do usuario
$us = $row;
$row2 = $User->BuscarTudo2($userLog); // Busca todas as informações do usuario
$admin = $User->BuscarAdmin(); // Busca todas as informações do ADMIN
$all = $User->BuscarAll(); // Busca todas as informações do usuario
$indi = $User->ContarIndiretos($row->patrocinador); // Busca todas as informações do usuario
$all2 = $User->BuscarOnline(); // Busca todas as informações do usuario
$kit = $User->BuscarPlan($row->plan); // Busca todas as informações do PLANO
$n_invoice = $User->ContarInvoice($row->personal_id); // Conta o numero de invoices
$c_patrocinador = $User->ContarIndicados($userLog); // Conta o numero de invoices
$row_renovar = $User->BuscarRenovacao($userLog); // Muda status para Renovar caso vença a Data]
$day = date("Y-m-d");
$saques_dia = $User->BuscarWhitdraw_date($row->username,$day); // Busca total ganho peo usuarios
$roo2 = $User->BuscarWhitdraw($row->username,$day); // Busca total ganho peo usuarios
$Binario->planoDeCarreira = $Binario->soma($row->personal_id);
$Binario->equiparados = $Binario->soma($row->personal_id);
$total_ganho2 = $row->renovar_saldo;
$rede = $c_patrocinador;

if($row->status != "Ativo"){
    $sts = "red";
}


if($row->block == "Bloqueado"){
    ?>
    <script>alert("Sua conta está bloquada para acesso !"),window.location='logout'</script>
<?php
}
$valor_renovar = $kit->price_btc*2;
$valor_renovar_more = $kit->price*2;
//Arquivo com todos os _POSTS do Site
include_once("../scripts/Classes/actions/_Posts.php");
include_once("../scripts/Classes/actions/_Get.php");
//include_once("../scripts/Classes/actions/rules.php");
include_once("logica_binario.php");
$total_i = $kit->price*2;
$total_i2 = $kit->price*2;
$dez_p = $total_i*10/100;
$vinte_p = $total_i*20/100;
$trinta_p = $total_i*30/100;
$quarenta_p = $total_i*40/100;
$cinquenta_p = $total_i*50/100;
$sensenta_p = $total_i*60/100;
$setenta_p = $total_i*70/100;
$renovar = $total_i2*100/100;
$oitenta_p = $total_i*80/100;
$noventa_p = $total_i*90/100;
$cem_p = $total_i;
$teto_saque = $kit->price;
if($total_ganho2 >= $dez_p){
    $color_progress = "green";
    $T = 10;
}
if($total_ganho2 >= $vinte_p) {
    $color_progress = "green";
    $T = 20;
}
if($total_ganho2 >= $trinta_p) {
    $color_progress = "green";
    $T = 30;
}
if($total_ganho2 >= $quarenta_p) {
    $color_progress = "green";
    $T = 40;
}
if($total_ganho2 >= $cinquenta_p) {
    $color_progress = "orange";
    $T = 50;
}
if($total_ganho2 >= $sensenta_p) {
    $color_progress = "orange";
    $T = 60;
}
if($total_ganho2 >= $setenta_p) {
    $color_progress = "orange";
    $T = 70;
}
if($total_ganho2 >= $oitenta_p) {
    $color_progress = "orange";
    $T = 80;
}
if($total_ganho2 >= $noventa_p) {
    $color_progress = "orange";
    $T = 90;
}
if($total_ganho2 >= $cem_p) {
    $color_progress = "red";
    $T = 100;
}
if($row->renovar_saldo >= $renovar AND $row->status =='Ativo' ) {
    if($row->plan >1) {
        $pdo->pdo->query("UPDATE financeiro SET status='Renovar' WHERE username='$row->username' AND personal_id='$row->personal_id'");
        $valor = $kit->price;
        $sql = $pdo->pdo->query("SELECT * FROM invoice_upgrade WHERE descricao='Renewal invoice' AND status='Pending' AND username='$row->username'");
        if ($sql->rowCount() > 0) {
            $sql = $pdo->pdo->query("UPDATE invoice_upgrade SET patrocinador='$row->patrocinador' WHERE username='$row->username' AND status='Pending'");
            ?>
            <script>alert("Voce precisa renovar sua conta"), window.location = 'pedidos'</script>
        <?php
        } else {
            $date = date("Y-m-d");
            $pedido = rand(000000000, 999999999);
            $sql = $pdo->pdo->query("INSERT INTO invoice_upgrade (personal_id,username,pedido,descricao,date,status,price_now,patrocinador,price_up,saldo_renew) VALUES('$row->personal_id','$row->username','$pedido','Renewal invoice','$date','Pending','$valor','$row->patrocinador','$kit->price','$total_ganho2')");
            ?>
            <script>window.location = 'pedidos'</script>
        <?php
        }

    }
}


if(isset($ct->valor)){
    $cota_dia = number_format($ct->valor,2,",",".") ;
    $data_cota = date("d/m/Y",strtotime($ct->data));
}else{
    $cota_dia = "";
    $data_cota = "";
}



$dolar = "3.14";

$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
$symbian =  strpos($_SERVER['HTTP_USER_AGENT'],"Symbian");
if ($iphone || $ipad || $android || $palmpre || $ipod || $berry || $symbian == true):
    $menu = true;
else : /* Caso contrário, faça/escreva o seguinte */
    $menu = false;
endif; ?>




