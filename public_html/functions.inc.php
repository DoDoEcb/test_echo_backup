<?php


DEFINE('DIR_ROOT',str_replace("//","/",str_replace($_SERVER['DOCUMENT_ROOT'],"/",str_replace("\\","/",dirname(__FILE__))."/")));

if(!isset($_GET['p'])):$_GET['p'] = 'home';endif;

$get = explode("/",$_GET['p']);

$ultimo_get = "";

foreach($get as $key => $val){
    if($key == 0):$_GET['pg']=$val;endif;
    if($key == 1):$_GET['ref']=$val;endif;
    $_GET['ref'.$key] = $val;
    if(!empty($ultimo_get)){
        $_GET[$ultimo_get] = $val;
    }
    $ultimo_get = $val;
}

error_reporting(E_ALL);
foreach($_GET as $key => $val){

    $_GET[$key] = str_replace("'","''",$_GET[$key]);

}
foreach($_POST as $key => $val){

    $_POST[$key] = str_replace("'","''",$_POST[$key]);

}
if(isset($_GET['pg']) and $_GET['pg'] == 'cadastro' and isset($_GET['ref2'])){

    $_GET['ref'] = $_GET['ref2'];
}

function vp($arr){
    echo "<pre>";
    var_dump($arr);
    echo "</pre>";
}
$http = "http";

if($_SERVER['HTTP_HOST'] == 'env-4245273.jelasticlw.com.br'){
    $http = "https";
}
$host = $http."://".$_SERVER['HTTP_HOST'];


$base = DIR_ROOT;


define("base_host",$host);
$base_proj = base_host.$base;
if($_SERVER['HTTP_HOST'] == '22env-4245273.jelasticlw.com.br'){
    $base = "/";
    $base_proj = base_host.$base;
}


define("base_dir",$base);
define("base_proj",$base_proj);
define("base_site",base_host."".base_dir."base-site/");
define("base_escritorio",base_host."".base_dir."base-escritorio/");

function teste($teste){

    return str_replace('href="$','href="'.base_prof,$teste);

}



?>