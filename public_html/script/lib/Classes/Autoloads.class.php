<?php


/*
	funcao de autoload dos arquivos das class's php
		*dar includes automaticamente ao instanciar as classes
*/
define("dir_classes","script/lib/Classes/");

function __autoload($classe){
	
	$inc = dir_classes.$classe.".class.php";
	
	if(file_exists(dir_classes.$classe."/".$classe.".class.php")){
	
		$inc = dir_classes.$classe."/".$classe.".class.php";
	}
	
	/*Muda o diretorio padrão para o da nova aplicação quando é instanciado um classe,
		se essa classe existir e foi especificada em diretorios.php
	*/
	include "script/diretorios.php";
	
	foreach($dir_cls as $k => $v){
		
		if($inc == dir_classes.$classe.".class.php" and $k == $classe){
			$inc = $v . dir_classes.$classe.".class.php";
			if(file_exists($v . dir_classes.$classe."/".$classe.".class.php")){
	
				$inc = $v . dir_classes.$classe."/".$classe.".class.php";
			}
		}
	}/**/
	

	require_once($inc);
	
}

?>