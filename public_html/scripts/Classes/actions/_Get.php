<?php
/**
 * Created by PhpStorm.
 * User: elifas
 * Date: 07/11/16
 * Time: 10:00
 */
require_once("_Functions.php");
$_Function = new _Functions();
if(isset($_GET['invoice'])){

$row_invoice = $_Function->BuscarInvoice($_GET['invoice']);

}