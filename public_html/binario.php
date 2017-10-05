
<?php


date_default_timezone_set('America/Sao_Paulo'); // atualizado em 19/08/2013

$base = __FILE__;

include_once "configs.php";
$Banco = new Banco();

if(isset($_GET['buscar']) and $_GET['buscar'] != ''){
	$buscar = $_GET['buscar'];
	$and = "";
	if(isset($_GET['id'])){
		$and = "and personal_id = '".$_GET['id']."'";
	}
	$Banco->Query("SELECT * FROM dados_acesso_usuario WHERE username like '%$buscar%' $and");

}

?>
<form method="GET">
	<input name="buscar" value="">
	<input type="submit">
</form>
<hr >

<?php
if(isset($_GET['buscar']) and $Banco->row <= 0){

}else{

	while($res = $Banco->retorno()){

		echo "<a href='?buscar=".$_GET['buscar']."&id=".$res->personal_id."'>$res->username</a><br>";
	}
	if(isset($_GET['id'])){

	exibeDados($_GET['id']);
	}
}

function exibeDados($id){
	exibeBinario($id);
	exibeDiretos($id);
}

function exibeBinario($id){

	$banco = new Banco();
	$banco->Query("SELECT * FROM rede_binaria  INNER JOIN dados_acesso_usuario ON rede_binaria.indicado_id = dados_acesso_usuario.personal_id WHERE rede_binaria.personal_id = '$id' and nivel = 1");
	if($banco->row < 1){ return false;}
	echo "<p style='padding:10px;'> pernas no binario<br>";
	while($res = $banco->retorno()){
		echo $res->username."-".$res->log_perna;
		echo "<br />";
	}
	echo "</p>";
}
function exibeDiretos($id){
	$banco = new Banco();
	$banco->Query("SELECT * FROM dados_acesso_usuario WHERE indicacao_id = '$id'");
	if($banco->row < 1){ return false;}
	echo "<p style='padding:10px;'> pernas no binario<br>";
	while($res = $banco->retorno()){
		echo $res->username."-".$res->status;
		echo "<br />";

	}
	echo "</p>";
}
?>