<?php
/**
 * Created by PhpStorm.
 * User: elifas
 * Date: 27/04/17
 * Time: 02:47
 */
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
require_once("Classes/connection/connect.php");
$pdo =new Connection();
require_once("../scripts/Classes/Binario.php");
$Binario = new Binario();
$pdo->Connect();

$sql = $pdo->pdo->query("SELECT * FROM financeiro as f INNER JOIN plan as p  ON f.plan=p.id WHERE f.status='Ativo'");
if($sql->rowCount()>0) {
$res = $sql->fetchAll(PDO::FETCH_OBJ);

    foreach($res as $row){

        $esquerda = $pdo->pdo->query("SELECT * FROM rede_binaria WHERE personal_id='$row->personal_id' and log_perna = 'esquerda'");
        if($esquerda->rowCount() <= 0){
            $direito_esquerda = 0;
        }else{
            $res = $esquerda->fetch(PDO::FETCH_OBJ);
            $direito_esquerda = $res->indicado_id;
        }

        $esquerda = $pdo->pdo->query("SELECT * FROM rede_binaria WHERE personal_id='$row->personal_id' and log_perna = 'direita'");
        if($esquerda->rowCount() <= 0){
            $direito_direita =0;
        }else{
            $res = $esquerda->fetch(PDO::FETCH_OBJ);
            $direito_direita = $res->indicado_id;
        }

        $chave_esq = $Binario->PegarPernaEsquerda($row->personal_id);

        $chave_dir = $Binario->PegarPernaDireta($row->personal_id);

        $_esquerda_dentro =$Binario->pegaChaveDentro($chave_esq);
        $_direita_dentro = $Binario->pegaChaveDentro($chave_dir);


        $minha_esquerda = $_esquerda_dentro.",".$chave_esq;
        $minha_direita = $_direita_dentro.",".$chave_dir;
        $pontos_esquerda = $Binario->SomarPontos($minha_esquerda) -  $Binario->somaEsquerda($row->personal_id);
            $pontos_direita = $Binario->SomarPontos($minha_direita) - $Binario->somaDireita($row->personal_id);


        if($pontos_esquerda > $pontos_direita){
            $bonus = $pontos_direita;
            $perna_menor = 'direita';
        }else{
            $bonus = $pontos_esquerda;
            $perna_menor = 'esquerda';
        }




        $query =  $pdo->pdo->query("SELECT * FROM financeiro as f INNER JOIN dados_acesso_usuario as da on f.personal_id=da.personal_id WHERE da.indication='$row->username' AND da.direcao_cadastro='direita' AND f.status='Ativo'  ");
        $equipedireira = $query->rowCount();


//Conta usuarios do binario
        $query =  $pdo->pdo->query("SELECT * FROM financeiro as f INNER JOIN dados_acesso_usuario as da on f.personal_id=da.personal_id WHERE da.indication='$row->username' AND da.direcao_cadastro='esquerda' AND f.status='Ativo'");
        $equipeesquerda = $query->rowCount();


        if($equipedireira > 0 AND $equipeesquerda > 0){


            $qualificado = "Qualificado";
            $color_binario = "green";
            $query =  $pdo->pdo->query("UPDATE financeiro SET binario_status='qualificado' WHERE personal_id='$row->personal_id'");

            $Binario->bonifica($row->personal_id, $bonus, $row->price_btc, $minha_esquerda, $minha_direita, $perna_menor, $row->username, $pontos_esquerda, $pontos_direita,$row->binario,$qualificado);
        }else{
            $qualificado = "Não Qualificado";
            $color_binario = "orange";
            $query =  $pdo->pdo->query("UPDATE financeiro SET binario_status='nao qualificado' WHERE personal_id='$row->personal_id'");
            $Binario->bonifica($row->personal_id, $bonus, $row->price, $minha_esquerda, $minha_direita, $perna_menor, $row->username, $pontos_esquerda, $pontos_direita,$row->binario,$qualificado);
        }


        }


}

?>
