<?php 

@mysql_connect('localhost','root','')or die(mysql_error());

@mysql_select_db('hexa')or die(mysql_error());

$teste = "";
error_reporting(E_ALL);

$rede = mysql_query("SELECT * FROM rede_binaria LEFT JOIN dados_acesso_usuario ON rede_binaria.personal_id = dados_acesso_usuario.personal_id WHERE dados_acesso_usuario.status = 'Ativo' and (dados_acesso_usuario.package != '0' and package != 'Kit Cadastro') group by rede_binaria.personal_id")or die(mysql_error());
while($res = mysql_fetch_object($rede)){
	echo "<br>".$res->personal_id."<br>";
	//verificar se esta qualificado
	if(ehQualificado($res->personal_id) == true){
		echo $res->personal_id." estava qualificado<br>";
		$chave_esq = pegaChaveEsquerda($res->personal_id);
		$chave_dir = pegaChaveDireita($res->personal_id);
		$chave_direita = removeFalhas($chave_dir).",".removeFalhas(pegaChaveDentro($chave_dir));
		$chave_esquerda = removeFalhas($chave_esq).",".removeFalhas(pegaChaveDentro($chave_esq));
		
		$bonus_esquerda = calculaBonus($chave_esquerda);
		$bonus_direita = calculaBonus($chave_direita);
		if(($bonus_esquerda == 0 and $bonus_direita == 0) == false){
			if($bonus_esquerda <= $bonus_direita){
			echo "<br>||| $bonus_esquerda <= $bonus_direita recebeu bonus da perna esquerda |||<br>";
			}else{
				echo "<br>||| $bonus_esquerda <= $bonus_direita recebeu bonus da perna direita |||<br>";
			}
		}else{
			echo "<br>||| $bonus_esquerda == $bonus_direita NAO RECEBEU NADA |||<br>";
		}
		
		
	}else{
		echo "<br>".$res->personal_id." NÂO estava qualificado<br>";
	}
}
function calCulaBonus($chave){
	$chave = removeFalhas($chave);
	$calc = mysql_query("SELECT SUM(bonus_binario) as bonus FROM `dados_acesso_usuario`
						LEFT JOIN pacotes ON nome_pacote = package OR pacotes.code = package
						WHERE personal_id IN ($chave) and status = 'Ativo' and (package != 'Kit Cadastro' and package != '1') ORDER BY `dados_acesso_usuario`.`personal_id`  ASC")or die(mysql_error());
	if(mysql_num_rows($calc) <= 0){
		return 0;
	}
	
	$res = mysql_fetch_object($calc);
	return $res->bonus;
}
function ehQualificado($personal_id){
	$esq = mysql_query("SELECT * FROM rede_binaria LEFT JOIN dados_acesso_usuario ON rede_binaria.personal_id = dados_acesso_usuario.indicacao_id WHERE rede_binaria.personal_id = '$personal_id' and log_perna = 'esquerda' and dados_acesso_usuario.status = 'Ativo' and (dados_acesso_usuario.package != 'Kit Cadastro' and dados_acesso_usuario.package != '1')");

	if(mysql_num_rows($esq) <= 0){
		return false;
	}
	$dir = mysql_query("SELECT * FROM rede_binaria LEFT JOIN dados_acesso_usuario ON rede_binaria.personal_id = dados_acesso_usuario.indicacao_id WHERE rede_binaria.personal_id = '$personal_id' and log_perna = 'direita' and dados_acesso_usuario.status = 'Ativo' and (dados_acesso_usuario.package != 'Kit Cadastro' and dados_acesso_usuario.package != '1')");

	if(mysql_num_rows($dir) <= 0){
		return false;
	}
	return true;
}

function pegaChaveEsquerda($personal_id){
	$esquerda = mysql_query("SELECT * FROM rede_binaria WHERE personal_id = '$personal_id' and log_perna = 'esquerda'");
	if(mysql_num_rows($esquerda) <= 0){
		return "10";
	}else{
		$res = mysql_fetch_object($esquerda);
		return $res->indicado_id.",
		".pegaChaveEsquerda($res->indicado_id);
	}
	
}
function pegaChaveDireita($personal_id){
	$direita = mysql_query("SELECT * FROM rede_binaria WHERE personal_id = '$personal_id' and log_perna = 'direita'");
	if(mysql_num_rows($direita) <= 0){
		return "10";
	}else{
		$res = mysql_fetch_object($direita);
		return $res->indicado_id.",
		".pegaChaveDireita($res->indicado_id);
	}
	
}

function pegaChaveEsquerdaDentro($chave){
	
	$chave = explode(',',$chave);
	$nchave = "";
	foreach($chave as $k => $v){
		if(is_numeric($v) and $v > 0){
			$nchave .= $v.",";
		}
		
	}
	$nchave .= "10";
	
	$chave = $nchave;
	
	$rede = mysql_query("SELECT * FROM `dados_acesso_usuario` WHERE indicacao_id IN ($chave)");
	if(mysql_num_rows($rede) <= 0){
		return $chave;
	}
	$chave = "";
	
	while($res = mysql_fetch_object($rede)){
		$chave .= $res->personal_id.",";
	}
	
	return $chave.",".pegaChaveEsquerdaDentro($chave);
}
function pegaChaveDireitaDentro($chave){
	
	$chave = explode(',',$chave);
	$nchave = "";
	foreach($chave as $k => $v){
		if(is_numeric($v) and $v > 0){
			$nchave .= $v.",";
		}
		
	}
	$nchave .= "10";
	
	$chave = $nchave;
	
	$rede = mysql_query("SELECT * FROM `dados_acesso_usuario` WHERE indicacao_id IN ($chave)");
	if(mysql_num_rows($rede) <= 0){
		return $chave;
	}
	$chave = "";
	
	while($res = mysql_fetch_object($rede)){
		$chave .= $res->personal_id.",";
	}
	
	return $chave.",".pegaChaveDireitaDentro($chave);
}

function pegaChaveDentro($chave){
	
	$chave = explode(',',$chave);
	$nchave = "";
	foreach($chave as $k => $v){
		if(is_numeric($v) and $v > 0){
			$nchave .= $v.",";
		}
		
	}
	$nchave .= "10";
	
	$chave = $nchave;
	
	$rede = mysql_query("SELECT * FROM `dados_acesso_usuario` WHERE indicacao_id IN ($chave)");
	if(mysql_num_rows($rede) <= 0){
		return $chave;
	}
	$chave = "";
	
	while($res = mysql_fetch_object($rede)){
		$chave .= $res->personal_id.",";
	}
	
	return $chave.",".pegaChaveDentro($chave);
}

function removeFalhas($chave){
	$chave = explode(',',$chave);
	$nchave = "";
	foreach($chave as $k => $v){
		if(is_numeric($v) and $v > 0){
			$nchave .= $v.",";
		}
		
	}
	$chave = $nchave."10";
	return $chave;
}

?>