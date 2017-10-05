<?php
require_once("scripts/Classes/connection/connect.php");
$pdo = new Connection();
$pdo->Connect();

if(isset($_POST['recuperar-senha'])) {
    ini_set('display_errors',1);
    ini_set('display_startup_erros',1);
    error_reporting(E_ALL);
    include_once("scripts/Classes/Recuperar_senha.php");
    $senha = new Recuperar_senha();

    $sql = $pdo->pdo->Query("SELECT id,username FROM usuarios where email='$_POST[email]'");
        $token = rand(00000000 , 11111111);
        $res = $sql->fetchAll(PDO::FETCH_OBJ);
    if($sql->rowCount() > 0 ){
    foreach ( $res as  $row) {


        $sql = $pdo->pdo->Query("UPDATE usuarios SET token='$token' WHERE username='$row->username'");
        $ref = $sql->fetchAll(PDO::FETCH_OBJ);

    }
        $data_envio = date('d/m/Y');
        $hora_envio = date('H:i:s');


        $senha->_senha($row->id);


    }else{
        ?>
        <script>alert("Email inválido , Por favor digite seu email corretamente !")</script>
        <?php

    }
    }
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- START @HEAD -->
<!-- Mirrored from themes.djavaui.com/blankon-fullpack-admin-theme/live-preview/admin/html/page-signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 30 Aug 2016 04:49:52 GMT'-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google. ">
    <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template,">
    <title>EmpireBits LLC</title>

    <!-- Favicons-->
    <link rel="icon" href="images/nada.png" sizes="32x32">
    <!-- Favicons-->
    <link rel="apple-touch-icon-precomposed" href="images/nada.png">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#00bcd4">
    <meta name="msapplication-TileImage" content="images/nada.png">
    <!-- For Windows Phone -->


    <!-- CORE CSS-->

    <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <!-- Custome CSS-->
    <link href="css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="css/layouts/page-center.css" type="text/css" rel="stylesheet" media="screen,projection">

    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">

</head>


<body style="background-image: url(img/bcg/bg.jpg)">

<!--[if lt IE 9]>
<![endif]-->

<!-- START @SIGN WRAPPER -->
<div id="sign-wrapper">

    <!-- Brand -->
    <div class="brand">
        <img src="images/nada.png" alt="brand logo" "/>
    </div>
    <!--/ Brand -->

    <div class="col 6 z-depth-4 card-panel" style="margin-left: 0;">
        <center> <form class="login-form" method="post" ">
                <div class="form-group"><br>
                    <div class="">
                        <input type="text" class="form-control " placeholder="Email" name="email">
                    </div>
                </div><!-- /.form-group -->
                <div class="row">
                    <div class="input-field col s12">
                        <input type="submit" name="recuperar-senha" value="Solicitar Nova Senha" class="btn btn-success" style="background-color: #45a4ff">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6 m6 l6">
                        <p class="margin medium-small"><a href="login.php">Voltar </a></p>
                    </div>
                    <div class="input-field col s6 m6 l6">
                        <p class="margin right-align medium-small"><a href="register.php">Cadastrar</a></p>
                    </div>
                </div>

            </form></center>
    </div>
</div>

</body>

<!-- Mirrored from demo.geekslabs.com/materialize/v2.1/layout03/user-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 02 Aug 2015 16:06:31 GMT -->
</html>
