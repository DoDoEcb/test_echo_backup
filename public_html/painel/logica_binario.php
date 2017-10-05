<?php
if(isset($_POST['Perna'])) {

    $perna = $_POST['Perna'][0];

    $inserir = $pdo->pdo->query("UPDATE dados_acesso_usuario SET perna ='$perna', direcao='$perna'  WHERE personal_id= '$us->personal_id'");
    ?>
    <meta http-equiv="refresh" content="0">
<?php
}
$equiparados = $Binario->somas($row->personal_id);
$esquerda = $pdo->pdo->query("SELECT * FROM rede_binaria WHERE personal_id='$us->personal_id' and log_perna = 'esquerda'");
if($esquerda->rowCount() <= 0){
    $direito_esquerda = 0;
}else{
    $res = $esquerda->fetch(PDO::FETCH_OBJ);
    $direito_esquerda = $res->indicado_id;
}

$esquerda = $pdo->pdo->query("SELECT * FROM rede_binaria WHERE personal_id='$us->personal_id' and log_perna = 'direita'");
if($esquerda->rowCount() <= 0){
    $direito_direita =0;
}else{
    $res = $esquerda->fetch(PDO::FETCH_OBJ);
    $direito_direita = $res->indicado_id;
}

$chave_esq = $Binario->PegarPernaEsquerda($us->personal_id);

$chave_dir = $Binario->PegarPernaDireta($us->personal_id);

 $_esquerda_dentro =$Binario->pegaChaveDentro($chave_esq);
$_direita_dentro = $Binario->pegaChaveDentro($chave_dir);


 $minha_esquerda = $_esquerda_dentro.",".$chave_esq;
$minha_direita = $_direita_dentro.",".$chave_dir;
$pontos_esquerda = $Binario->SomarPontos($minha_esquerda) -  $Binario->somaEsquerda($us->personal_id);
$pontos_direita = $Binario->SomarPontos($minha_direita) - $Binario->somaDireita($us->personal_id);

if(empty($pontos_esquerda)){
    $pontos_esquerda = 0;
}
if(empty($pontos_direita)){
    $pontos_direita = 0;
}

$esquerda = $pdo->pdo->query("SELECT COUNT(personal_id) as contar_esquerda FROM dados_acesso_usuario WHERE personal_id IN ($minha_esquerda)");
if($esquerda->rowCount() > 0) {
    $res = $esquerda->fetch(PDO::FETCH_OBJ);
    $equie = $res->contar_esquerda;
}

$direita = $pdo->pdo->query("SELECT COUNT(personal_id) as contar_direita FROM dados_acesso_usuario WHERE personal_id IN ($minha_direita)");
if($direita->rowCount() > 0) {
    $res = $direita->fetch(PDO::FETCH_OBJ);
    $equid = $res->contar_direita;
}



$query =  $pdo->pdo->query("SELECT * FROM financeiro as f INNER JOIN dados_acesso_usuario as da on f.personal_id=da.personal_id WHERE da.indication='$us->username' AND da.direcao_cadastro='direita' AND f.status='Ativo' AND f.plan>1 ");
    $equipedireira = $query->rowCount();


//Conta usuarios do binario
$query =  $pdo->pdo->query("SELECT * FROM financeiro as f INNER JOIN dados_acesso_usuario as da on f.personal_id=da.personal_id WHERE da.indication='$us->username' AND da.direcao_cadastro='esquerda' AND  f.status='Ativo' AND f.plan>1");
    $equipeesquerda = $query->rowCount();


if($equipedireira > 0 AND $equipeesquerda > 0){


    $qualificado = "Qualificado";
    $color_binario = "green";
    $query =  $pdo->pdo->query("UPDATE financeiro SET binario_status='qualificado' WHERE personal_id='$us->personal_id'");
}else{
    $qualificado = "Não Qualificado";
    $color_binario = "orange";

    $query =  $pdo->pdo->query("UPDATE financeiro SET binario_status='nao qualificado' WHERE personal_id='$us->personal_id'");

}
