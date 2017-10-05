<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once("scripts/Classes/connection/connect.php");
$pdo = new Connection();
$pdo->Connect();
if(isset($_GET['token'])){
    $token = $_GET['token'];
    $sql1 = $pdo->pdo->Query("SELECT * FROM usuarios where token='$_GET[token]'");
    $row = $sql1->fetchAll(PDO::FETCH_OBJ);
    if($sql1->rowCount() > 0){

    }else{
        ?>
        <script>alert("Token Invalido !")</script>
        <script>window.location='login.php'</script>
        <?php
    }

}else{
    ?>
    <script>alert("Token Invalido !")</script>
    <script>window.location='login.php'</script>
    <?php
}
    if(isset($_POST['set-senha'])) {

        $password = $_POST['password'];
        // Fazendo comparação de senhas do formulário de alteração.
        if($password == $_POST['cpassword']) {

            $password = md5($_POST['password']);

            $sql2 = $pdo->pdo->query("SELECT * FROM usuarios where token='$token'");
            if($sql2->rowCount() > 0) {
                $row2 = $sql2->fetchAll(PDO::FETCH_OBJ);
                foreach ($row2 as $ref) {
                    $username = $ref->username;
                    $update = $pdo->pdo->query("UPDATE usuarios SET password='$password' WHERE username='$username'");
                    $update = $pdo->pdo->query("UPDATE usuarios SET token='8981919' WHERE username='$username'");
                    ?>
                    <script>alert("Sua senha foi alterada com sucesso !")</script>
                    <script>window.location='login.php'</script>
                    <?php

                }
            } else {

                ?>
                <script>alert("Senha alterada com sucesso !")</script>
                <script>window.location = 'login.php'</script>
                <?php
            }

        }else{
            ?>
            <script>alert("Senha não corresponde com a confirmação !")</script>
            <?php
        }
    }
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="pt-br" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="pt-br" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="pt-br"> <!--<![endif]-->
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




<div id="sign-wrapper">

    <!-- Brand -->
    <div class="brand">
        <img src="images/nada.png" alt="brand logo"/>
    </div>
    <!--/ Brand -->

    <div class="col 6 z-depth-4 card-panel" style="margin-left: 0;">
        <center> <form class="login-form" method="post" >
                <div class="form-group"><br>
                    <div class="">
                        <input id="password" type="password" name="password" placeholder="Nova Senha" required="">
                    </div>
                </div><!-- /.form-group -->
                <div class="form-group"><br>
                    <div class="">
                        <input id="cpassword" type="password" name="cpassword" placeholder="Confirmar nova senha" required="">
                    </div>
                </div><!-- /.form-group -->
                <div class="row">
                    <div class="input-field col s12">
                        <input type="submit" name="set-senha" value="Cadastrar Senha" class="btn btn-success" style="background-color: #45a4ff">
                    </div>
                </div>
                <div class="row"><br>
                    <div class="input-field col s6 m6 l6">
                        <p class="margin medium-small" ><a href="login.php"  style="color: whitesmoke">Voltar </a></p>
                        <p class="margin right-align medium-small"><a href="register.php"  style="color: whitesmoke">Cadastrar</a></p>
                    </div>
                </div>

            </form></center>
    </div>
</div>
<!-- START JAVASCRIPT SECTION (Load javascripts at bot
</body>

<!-- Mirrored from demo.geekslabs.com/materialize/v2.1/layout03/user-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 02 Aug 2015 16:06:31 GMT -->
</html>