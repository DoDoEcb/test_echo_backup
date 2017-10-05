<?php
if(isset($_POST['set-login'])){
    require_once("scripts/Classes/Login.php");
    $Login = new Login();

    if($Login->Logar($_POST['admuser'],md5($_POST['admpass'])) == true){
        session_start();
        $_SESSION['admuser'] = $_POST['admuser'];
        $_SESSION['admpass'] = md5($_POST['admpass']);

        $erro = ' <div class="alert success rounded">
        <i class="fa fa-info-circle"></i> Logged in successfully
    </div><script>window.location="index.php"</script>';

    }else{

        $erro = ' <div class="alert error rounded">
        <i class="fa fa-info-circle"></i> Wrong username and password combination
    </div>';
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Matrix Admin</title><meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="css/matrix-login.css" />
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

</head>
<body>
<div id="loginbox">
    <form class="form-vertical" method="post">
        <?php
        if(isset($erro)){
            echo $erro;
        }
        ?>
        <div class="control-group normal_text"> <h3><img src="http://www.impactusbit.com/images/generic-logo.png" alt="Logo" /></h3></div>
        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lg"><i class="icon-user"></i></span><input type="text" name="admuser" placeholder="Username"/>
                </div>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_ly"><i class="icon-lock"></i></span><input type="password" name="admpass" placeholder="Password"/>
                </div>
            </div>
        </div>
        <div class="form-actions">
          <center><button class="btn btn-success" name="set-login" type="submit" style="width:60%;">Login</button></center>
        </div>
    </form>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/matrix.login.js"></script>
</body>

</html>
