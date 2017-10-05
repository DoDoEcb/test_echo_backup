<?php
require_once("scripts/Classes/Register.php");
require_once("scripts/Classes/connection/connect.php");
$pdo = new Connection();
$pdo->Connect();
$Register = new Register();


if(isset($_POST['set-register'])){


    if($Register->existeUsuario($_POST['username']) == true){

        ?>
        <script>alert("Nome de usuário já cadastrado")</script>
    <?php
    }else{



        if($Register->ExisteEmail($_POST['email']) == true){

           ?>
<script>alert("E-mail já está em uso")</script>
            <?php


        }else{

            if($_POST['password'] != $_POST['cpassword']){
                ?>
                <script>alert("A senha não corresponde com a confirmação")</script>
                <?php


            }else{


                if(strlen($_POST['name']) <= 4 ){
                    ?>
                    <script>alert("Preencha com seu nome completo")</script>
                <?php


                }else{

                    if(strlen($_POST['username']) <= 5 ) {
                        ?>
                        <script>alert("O nome de usuário deve conter 6 caracters")</script>
                    <?php

                    }else{

                        if(strlen($_POST['password']) <= 6 ) {
                            ?>
                            <script>alert("A senha deve conter no minino 6 caracteres")</script>
                        <?php

                        }else{

                            if($Register->ExisteCpf($_POST['cpf']) == true){
                                ?>
                                <script>alert("Já exite um registro neste cpf")</script>
                            <?php


                            }else{


                               // $Register->Cadastro($_POST['name'],$_POST['email'],$_POST['username'],$_POST['adress'],$_POST['phone'],$_POST['cpf'],md5($_POST['password']),$_POST['patrocinador']);
                                $token = rand(0000000,9999999);
                                //   $Register->Sendemail($_POST['email'],$_POST['name'],$token,$_POST['username']);
                                $Register->Cadastro($_POST['name'],$_POST['email'],$_POST['username'],$_POST['adress'],$_POST['phone'],$_POST['cpf'],md5($_POST['password']),$_POST['patrocinador'],$token,1);


?>
<script>alert("Sua conta foi registrada com sucesso!"),window.location="login.php"</script>
<?php


                            }

                        }
                    }
                }
            }
        }
    }


}

if(isset($_GET['ref'])){
    if($Register->VerificaPatrocinador($_GET['ref']) == true){

        $row = $Register->PegarNomePatrocinador($_GET['ref']);

        $patrocinador = $row->name;
        $patro = $row->username;

    }else{
        ?>
        <script>alert("Você precisa de um patrocinador  ")</script>
        <?php
    }



}

include_once("validacoes.html");
?>
<!DOCTYPE html>
<html lang="en">

<!--================================================================================
	Item Name: Materialize - Material Design Admin Template
	Version: 3.1
	Author: GeeksLabs
	Author URL: http://www.themeforest.net/user/geekslabs
================================================================================ -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google. ">
    <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template,">
    <title>ImpactusBit</title>

    <!-- Favicons-->
    <link rel="icon" href="images/nada.png" sizes="64x64">
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

<body style="background-image: url(images/user-profile-bg.jpg);background-size: cover">
<!-- Start Page Loading -->
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>
<!-- End Page Loading -->


<center style="margin-left: 10%"><br>
    <img src="images/generic-logo.png" width="70%">
    <div  class="row" style="margin-left: 9%;">

    <div class="col s16 z-depth- card-panel">
        <form class="login-form" method="post">
            <div class="row">
                <div class="input-field col s12 center">
                    <p class="center login-form-text">Registrar</p>
                </div>
            </div>
            <center><?php echo isset($patro)?$patro:''?></center>
            <input class="form-control" name="patrocinador" type="hidden"  value="<?php echo isset($patro)?$patro:'empirebits'?>" required=""  style="color: black">
            <div class="row margin">
                <div class="input-field col s12">
                    <i class="mdi-social-person-outline prefix"></i>
                    <input type="text" placeholder="Full Name" name='name' value="<?php echo isset($_POST['name'])?$_POST['name']:''?>" required="" class="form-control" style="color:black;">
                    <label for="name" class="center-align" >Nome Completo</label>
                </div>
            </div>
            <div class="row margin">
                <div class="input-field col s12">
                    <i class="mdi-social-person prefix"></i>
                    <input type="text"  placeholder="Username" name='username' value="<?php echo isset($_POST['username'])?$_POST['username']:''?>" required="" class="form-control" style="color:black;">
                    <label for="username">Nome de Usuário</label>
                </div>
            </div>
            <div class="row margin">
                <div class="input-field col s12">
                    <i class="mdi-action-credit-card prefix"></i>
                    <input type="text" placeholder="Tax-id" name="cpf"  maxlength="14" onkeyup="FormataCpf(this,event)" onkeypress='return SomenteNumero(event)'  onblur="return verificarCPF(this.value)" class="form-control"  style="color:black;">
                    <label for="cpf">CPF</label>
                </div>
            </div>
            <div class="row margin">
                <div class="input-field col s12">
                    <i class="mdi-communication-phone prefix"></i>
                    <input type="tel" placeholder="Phone" name='phone'  value="<?php echo isset($_POST['phone'])?$_POST['phone']:''?>"  required="" class="form-control"  style="color:black;">
                    <label for="username">Telefone</label>
                </div>
            </div>
            <div class="row margin">
                <div class="input-field col s12">
                    <i class="mdi-communication-location-on prefix"></i>
                    <input type="text" placeholder="Adress" name="adress"  value="<?php echo isset($_POST['adress'])?$_POST['adress']:''?>"  required="" class="form-control"  style="color:black;">
                    <label for="adress">Endereço</label>
                </div>
            </div>
            <div class="row margin">
                <div class="input-field col s12">
                    <i class="mdi-content-mail prefix"></i>
                    <input type="text" name="email"  placeholder="Email"  value="<?php echo isset($_POST['email'])?$_POST['email']:''?>" required="" class="form-control"  style="color:black;">
                    <label for="email">Email</label>
                </div>
            </div>
            <div class="row margin">
                <div class="input-field col s12">
                    <i class="mdi-action-lock prefix"></i>
                    <input type="password" placeholder="Password" name="password" required="" class="form-control"  style="color:black;">
                    <label for="password">Senha</label>
                </div>
            </div>
            <div class="row margin">
                <div class="input-field col s12">
                    <i class="mdi-action-lock-outline prefix"></i>
                    <input type="password" placeholder="Confirm Password" name="cpassword" class="form-control" required=""  style="color:black;">
                    <label for="cpassword">Confirmar Senha</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <button class="btn waves-effect waves col s12"  style="background-color: #cda453"  name="set-register">Registrar</button>
                </div>
            </div>
           <center> <div class="row">
                <div class="input-field col s6 m6 l6">
                    <p class="margin medium-small"><a href="login.php">Login!</a></p>
                </div>
            </div></center>

        </form>
    </div>
</div>
    </center>



<!-- ================================================
  Scripts
  ================================================ -->

<!-- jQuery Library -->
<script type="text/javascript" src="js/plugins/jquery-1.11.2.min.js"></script>
<!--materialize js-->
<script type="text/javascript" src="js/materialize.min.js"></script>
<!--prism-->
<script type="text/javascript" src="js/plugins/prism/prism.js"></script>
<!--scrollbar-->
<script type="text/javascript" src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="js/plugins.min.js"></script>
<!--custom-script.js - Add your own theme custom JS-->
<script type="text/javascript" src="js/custom-script.js"></script>

</body>

</html>