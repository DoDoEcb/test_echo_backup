<?php

include_once("../scripts/Classes/connection/connect.php");
include_once("scripts/Classes/_Functions.php");
session_start();
$userLog =  $_SESSION['admuser'];
$passLog =  $_SESSION['admpass'];
if(!isset($_SESSION['admuser'])||!isset($_SESSION['admpass'])){
?>
    <script>window.location='../login.php'</script>
    <?php

}
$_Functions = new _Functions();

$pdo = new Connection();
$pdo->Connect();

//$N_users_ativo = $_Functions->ContarUsuarios("Ativo"); // Contar Usuarios Ativo
//$N_users_Renovar = $_Functions->ContarUsuarios("Renovar"); // Contar Usuarios Renovar
//$N_users_Online = $_Functions->ContarOnline(); // Contar Usuarios Online
//$N_users_Entrada_dolar = $_Functions->SomarEntrada("price"); // Contar Usuarios Online
//$N_users_Entrada_btc = $_Functions->SomarEntrada("price_btc"); // Valor de Receita
$N_users_Retirada_Pago = $_Functions->Retirada("Payd"); //Valor de Retiradas Pagas
$N_users_Retirada_Pendente = $_Functions->Retirada("Pending"); //Valor de Retiradas Pendentes
//$N_plan_b = $_Functions->ContaPlan("Bronze"); //Conta Pacotes Bronze
//$N_plan_p = $_Functions->ContaPlan("Prata"); //Conta Pacotes Prata
//$N_plan_o = $_Functions->ContaPlan("Ouro"); //Conta Pacotes Ouro
//$N_plan_e = $_Functions->ContaPlan("Esmeralda"); //Conta Pacotes Esmeralda
//$N_plan_d = $_Functions->ContaPlan("Diamante"); //Conta Pacotes Diamante
$admin = $_Functions->Admin(); //Conta Pacotes Diamante


if(isset($_GET['active_user'])){

    $_Functions->ActiveUsuario($_GET['active_user']);

    ?>
    <script>
        alert("Usuarios Ativo !"),window.location='enabled-users';
    </script>
<?php
}

if(isset($_GET['block_user'])){

    $_Functions->BloquearUsuario($_GET['block_user'],'Bloqueado');
    ?>
    <script>
        alert("Usuario Bloqueado com sucesso !"),window.location='enabled-users';
    </script>
<?php

}

if(isset($_GET['Unblock_user'])) {

    $_Functions->BloquearUsuario($_GET['Unblock_user'], "Desbloqueado");
    ?>
    <script>
        alert("Usuario Bloqueado com sucesso !"), window.location = 'block-users';
    </script>
<?php


}

if(isset($_GET['del_user'])){

    $_Functions->DeletarUsuario($_GET['del_user']);
    ?>
    <script>
        alert("Usuario deletado com sucesso"),window.location='block-users';
    </script>
<?php

}


if(isset($_GET['payfor'])){

    $_Functions->SetPayWithdraw($_GET['payfor'],$_GET['pedido'],$_GET['valor'],$_GET['username']);
    ?>
    <script>
        alert("Saque Marcado como Pago"),window.location='withdrawal-request.php';
    </script>
<?php

}

if(isset($_GET['confirm'])){

    $_Functions->ConfirmRenovar($_GET['confirm'],$_GET['username'],$_GET['saldo'],$_GET['valor'],$_GET['patrocinador']);
    ?>
    <script>
        alert("Usuario Renovado "),window.location='renovacao';
    </script>
<?php


}


if(isset($_GET['qualifi'])){

    $_Functions->Qualificar($_GET['qualifi'],"On");
    ?>
    <script>alert("Usuario Qualificado para sacar "),window.location='all-users'</script>
    <?php
}

if(isset($_GET['desqualifi'])){

    $_Functions->Qualificar($_GET['desqualifi'],"off");
    ?>
    <script>alert("Usuario Desqualificado para sacar "),window.location='all-users'</script>
<?php
}

if(isset($_POST['estorna'])){

    var_dump($_POST);
    if(isset($_POST['Motivo'])){
        $motivo = $_POST['Motivo'];
    }else{
        $motivo = "Nao Especificado";
    }
        $_Functions->EstornarSaque($_POST['estorna'],$motivo);

}

if(isset($_POST['set-save'])){

    $_Functions->EditarUsuario($_POST['data_registro'],$_POST['name'],$_POST['username'],$_POST['email'],$_POST['patrocinador'],$_POST['adress'],$_POST['cpf'],$_POST['phone'],$_POST['ip'],$_GET['edit_user']);
    ?>
    <script>
        alert("Usuario Editado"),window.location='profile?edit_user=<?php echo $_GET['edit_user']?>';
    </script>
<?php


}

if(isset($_POST['set-save2'])){

    if(isset($_POST['password'])){
        $_Functions->EditarSenha(md5($_POST['password']),$_GET['edit_user']);
        ?>
        <script>
            alert("Usuario Editado"),window.location='profile?edit_user=<?php echo $_GET['edit_user']?>';
        </script>
    <?php

    }
    if(isset($_POST['pin'])){

        $_Functions->EditarPin(md5($_POST['pin']),$_GET['edit_user']);
        ?>
        <script>
            alert("Usuario Editado"),window.location='profile?edit_user=<?php echo $_GET['edit_user']?>';
        </script>
    <?php
    }
   $_Functions->EditarUsuario2($_POST['saldo'],$_POST['saldo_ind'],$_POST['plan'],$_POST['wallet'],$_POST['status'],$_GET['edit_user']);
    ?>
    <script>
        alert("Usuario Editado"),window.location='profile?edit_user=<?php echo $_GET['edit_user']?>';
    </script>
<?php


}


if(isset($_GET['Act'])){

$_Functions->AtivarUpgrade($_GET['valor'],$_GET['patrocinador'],$_GET['personal_id'],$_GET['username'],$_GET['plan_up'],$_GET['pedido_id']);

    ?>
    <script>
        alert("Upgrade Ativo com sucesso"),window.location='upgrade-request';
    </script>
<?php

}

if(isset($_POST['saque'])){


    $pdo->pdo->query("UPDATE admin SET saque='$_POST[saque]'");
    ?>

    <script>alert("Voce masrcou o saque como <?php echo $_POST['saque']?> "),window.location='index.php'</script>
<?php

}