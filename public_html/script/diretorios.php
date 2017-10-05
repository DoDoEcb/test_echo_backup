<?php 
error_reporting(E_ALL);

/*Mudar RAIZ do diretorio padrão da Classe

	ex: $MinhaClasse = new MinhaClasse();
		$dir_cls['MinhaClasse'] = "[pasta/MinhaClasse/] <== O DIRETORIO MUDADO | A ESTRUTURA NORMAL-> script/lib/Classes/MinhaClasse.class.php"; 
*/
$dir_cls['LojaHexa'] = "sys/loja/";
if($_GET['pg'] == 'loja' or $_GET['pg'] == 'hexaShop'){ $dir_cls['Banco'] = "sys/loja/"; }
$dir_cls['Produtos'] = "sys/loja/";


?>