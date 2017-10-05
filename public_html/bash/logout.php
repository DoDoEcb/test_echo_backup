<?php
require_once("../scripts/Classes/connection/connect.php");
$pdo = new Connection();
$pdo->Connect();

session_start();
session_destroy();
session_unset();
?>
<script>
    window.location='login.php'
</script>
