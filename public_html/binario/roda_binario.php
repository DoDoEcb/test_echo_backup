<?php 

date_default_timezone_set('America/Sao_Paulo'); // atualizado em 19/08/2013

$base = __FILE__;
include_once "../configs.php";

$origem = dirname(__FILE__);

include_once $_SERVER['DOCUMENT_ROOT']."/var_db.php";

error_reporting(E_ALL);

function getNum(){
	$selNum = mysql_query("SELECT * FROM binarios_bonificados ORDER BY num desc LIMIT 1")or die(mysql_error());
	if(mysql_num_rows($selNum) <= 0){
		$num = 1;
	}else{
		$res = mysql_fetch_object($selNum);
		$num = $res->num+1;
	}
	
	return $num;
}
DEFINE("NUM",getNum());
echo "Binario n°{".NUM."}";
$Data = isset($_GET['data']) ? $_GET['data'] : '';

$whereData = empty($Data) ? '' : "and not exists(SELECT bonus FROM binarios_bonificados WHERE binarios_bonificados.personal_id = dados_acesso_usuario.personal_id and Data = '$Data')";

$rede = mysql_query("SELECT * FROM rede_binaria LEFT JOIN dados_acesso_usuario ON rede_binaria.personal_id = dados_acesso_usuario.personal_id WHERE dados_acesso_usuario.status = 'Ativo' and (dados_acesso_usuario.package != '0' and package != 'Kit Cadastro') group by rede_binaria.personal_id")or die(mysql_error());
while($res = mysql_fetch_object($rede)){
	echo "<br>".$res->personal_id."<br>";
	//verificar se esta qualificado
	if(ehQualificado($res->personal_id) == true){
		echo $res->personal_id." estava qualificado<br>";
		echo $chave_esq = pegaChaveEsquerda($res->personal_id);
		$chave_dir = pegaChaveDireita($res->personal_id);
		
		$chave_direita = removeFalhas($chave_dir).",".removeFalhas(pegaChaveDentro($chave_dir));
		echo $chave_esquerda = removeFalhas($chave_esq).",".removeFalhas(pegaChaveDentro($chave_esq));
		$soma = soma($res->personal_id);
		$bonus_esquerda = calculaBonus($chave_esquerda)-$soma;
		$bonus_direita = calculaBonus($chave_direita)-$soma;
		if($res->status == 'Upgrade' and $res->package_alterior != ''){
			$res->package = $res->package_alterior;
			echo "<br > Esta em Status de upgrade  $res->package = $res->package_alterior;<br>";
		}
		$pacote = $res->package;
		
		$DuasPernasComBonus = ($bonus_esquerda <= 0 or $bonus_direita <= 0);
		if($DuasPernasComBonus == false){
			$dados_acesso = dados_acesso($res->personal_id);
			$saldo = $dados_acesso->remainder;
			$id_usuario = $dados_acesso->id;
			$username = $dados_acesso->username;
			
			$saldo_antes = $saldo;
			
			if($bonus_esquerda <= $bonus_direita){
			echo "<br>||| $bonus_esquerda <= $bonus_direita recebeu bonus da perna esquerda |||<br>";
			$bonus = $bonus_esquerda;
			$saldo_depois = $bonus;
			
			bonifica($res->personal_id,$bonus,$saldo_antes,$chave_esquerda,$chave_direita,'esquerda',$id_usuario,$username,$bonus_esquerda,$bonus_direita,$pacote);
			
			}else{
				echo "<br>||| $bonus_esquerda <= $bonus_direita recebeu bonus da perna direita |||<br>";
			$bonus = $bonus_direita;
			$saldo_depois = $bonus;
			
			bonifica($res->personal_id,$bonus,$saldo_antes,$chave_esquerda,$chave_direita,'direita',$id_usuario,$username,$bonus_esquerda,$bonus_direita,$pacote);
			}
		}else{
			echo "<br>||| $bonus_esquerda == $bonus_direita NAO RECEBEU NADA |||<br>";
		}
		
		
	}else{
		echo "<br>".$res->personal_id." NÂO estava qualificado<br>";
	}
}
function bonifica($personal_id,$bonus,$saldo_antes,$chave_esquerda,$chave_direita,$perna,$id_usuario,$username,$bonus_esquerda,$bonus_direita, $pacote){
	$limiteDia = 10000;
    $bonus_dia = $bonus;
    if($bonus > $limiteDia){
        echo " <br>Bonus = $bonus limite de $limiteDia doi atingido <br>";

        $bonus_dia = $limiteDia;
    }
	$porcentagem = porcentagem($pacote);
	$valor_final = $bonus_dia*$porcentagem/100;
	$saldo_depois = $saldo_antes+$valor_final;
	$num = NUM;
	$Data = date("Y-m-d");
	echo "<br>INSERT INTO binarios_bonificados (personal_id,bonus,saldo_antes,saldo_depois,valor_esquerda,valor_direita,chave_direita,
				chave_esquerda,perna_menor,data,num,pacote_bonificado) VALUES ('$personal_id','$bonus','$saldo_antes','$saldo_depois','$bonus_esquerda','$bonus_direita','$chave_direita',
				'$chave_esquerda','$perna','$Data','$num','$pacote')<br> ";
	mysql_query("INSERT INTO binarios_bonificados (personal_id,bonus,saldo_antes,saldo_depois,valor_esquerda,valor_direita,chave_direita,
				chave_esquerda,perna_menor,data,num,pacote_bonificado) VALUES ('$personal_id','$bonus','$saldo_antes','$saldo_depois','$bonus_esquerda','$bonus_direita','$chave_direita',
				'$chave_esquerda','$perna','$Data','$num','$pacote') ")or die(mysql_error());
	
	mysql_query("INSERT INTO extratos (dia, username_ind, historico, pontos, remainder_ind, personal_id,cotadia,valor )
					VALUES('$Data','$username','Pontos de binario perna $perna','$bonus','$saldo_depois','$id_usuario','','$valor_final')")or die(mysql_error());
					
	
	mysql_query("UPDATE dados_acesso_usuario SET remainder = '$saldo_depois' where personal_id = '$personal_id'")or die(mysql_error());
	
}
function porcentagem($pacote){
	$pacote = mysql_query("SELECT * FROM `pacotes` WHERE nome_pacote = '$pacote' or code = '$pacote'");
	$retorno = mysql_fetch_object($pacote);
	return $retorno->porcentagem;
}
function dados_acesso($personal_id){
	$saldo = mysql_query("SELECT remainder,username,id FROM dados_acesso_usuario WHERE personal_id = '$personal_id'");
	$res = mysql_fetch_object($saldo);
	return $res;
}
function soma($personal_id){
	
	$soma = mysql_query("SELECT SUM(bonus) as valor FROM binarios_bonificados WHERE personal_id = '$personal_id'");
	if(mysql_num_rows($soma) <= 0){
		return 0;
	}
	$res = mysql_fetch_object($soma);
	return $res->valor;
}
function calCulaBonus($chave){
	$chave = removeFalhas($chave);
	$calc = mysql_query("SELECT SUM(bonus_binario) as bonus FROM `dados_acesso_usuario`
						LEFT JOIN pacotes ON nome_pacote = package OR pacotes.code = package
						WHERE personal_id IN ($chave) and (status = 'Ativo' or status = 'Upgrade') and (package != 'Kit Cadastro' and package != '1') ORDER BY `dados_acesso_usuario`.`personal_id`  ASC")or die(mysql_error());
	
	$calc_Up = mysql_query("SELECT SUM(bonus_binario) as bonus_upgrade FROM `dados_acesso_usuario`
						LEFT JOIN pacotes ON nome_pacote = package OR pacotes.code = package
						WHERE personal_id IN ($chave) and package_anterior != '' and ( package != '1') ORDER BY `dados_acesso_usuario`.`personal_id`  ASC")or die(mysql_error());
	
	$res = mysql_fetch_object($calc);
	$res_Up = mysql_fetch_object($calc_Up);
	
	if(mysql_num_rows($calc) <= 0){
		return 0;
	}
	if($res_Up->bonus_upgrade > 0){
		$calc_Sobra = mysql_query("SELECT SUM(bonus_binario) as bonus FROM `dados_acesso_usuario`
						LEFT JOIN pacotes ON nome_pacote = package_anterior OR pacotes.code = package_anterior
						WHERE personal_id IN ($chave) and package_anterior != '' and (package_anterior != 'Kit Cadastro' and package != '1') ORDER BY `dados_acesso_usuario`.`personal_id`  ASC")or die(mysql_error());
		$res_Sobra = mysql_fetch_object($calc_Sobra);
		$sobra = $res_Sobra->bonus;
	}
	$sobra = isset($sobra) ? $sobra : 0;
	$bonus_upgrade = empty($res_Up->bonus_upgrade) ? 0 :  $res_Up->bonus_upgrade;
	
	$bonus = empty($res->bonus) ? 0 : $res->bonus;
	$res->bonus = ($bonus)-($bonus_upgrade-$sobra);
	echo "<br>$res->bonus = ($bonus)-($bonus_upgrade-$sobra);<br>";
	echo $res->bonus;
	return $res->bonus;
}
function ehQualificado($personal_id){
	$esq = mysql_query("SELECT * FROM rede_binaria LEFT JOIN dados_acesso_usuario ON rede_binaria.indicado_id = dados_acesso_usuario.personal_id WHERE dados_acesso_usuario.indicacao_id = '$personal_id' and log_perna = 'esquerda' and dados_acesso_usuario.status != 'Pendente' and (dados_acesso_usuario.package != 'Kit Cadastro' and dados_acesso_usuario.package != '1')");

	if(mysql_num_rows($esq) <= 0){
		echo "<br>Não  tem na esquerda</br>";
		return false;
	}
	$dir = mysql_query("SELECT * FROM rede_binaria LEFT JOIN dados_acesso_usuario ON rede_binaria.indicado_id = dados_acesso_usuario.personal_id WHERE dados_acesso_usuario.indicacao_id = '$personal_id' and log_perna = 'direita' and dados_acesso_usuario.status != 'Pendente' and (dados_acesso_usuario.package != 'Kit Cadastro' and dados_acesso_usuario.package != '1')");

	if(mysql_num_rows($dir) <= 0){
		echo "<br>Não  tem na direita</br>";
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