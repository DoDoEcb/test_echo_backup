<?php
/**
 * Created by PhpStorm.
 * User: elifas
 * Date: 06/11/16
 * Time: 20:10
 */
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require_once("_Functions.php");
$_Function = new _Functions();

if(isset($_POST['set-upgrade'])){

    if($total_ganho2 == 0){
    $sql = $pdo->pdo->prepare("SELECT * FROM plan WHERE name=:post");
    $smt = array(":post"=>$_POST['up_kit']);
    $sql->execute($smt);
    $res = $sql->fetch(PDO::FETCH_OBJ);
    $_Function->Upgrade($row->personal_id,$row->username,$kit->name,$_POST['up_kit'],$res->price_btc,$row->patrocinador,$kit->price_btc,$block_io);
    }else{
        ?>
        <script>
            alert("You have pending withdrawals, wait for the payment to be able to request an Upgrade"),window.location='index';
        </script>
    <?php
    }
}


if(isset($_POST['renovar'])) {
    $sql = $pdo->pdo->query("SELECT * FROM invoice_upgrade WHERE descricao='Renewal invoice' AND status='Pending' AND username='$row->username'");
    if ($sql->rowCount() > 0) {
        $sql = $pdo->pdo->query("UPDATE invoice_upgrade SET patrocinador='$row->patrocinador' WHERE username='$row->username' AND status='Pending'");
        ?>
        <script>alert("You need to renew your account"), window.location = 'invoice'</script>
    <?php
    } else {
        $date = date("Y-m-d");
        $pedido = rand(000000000, 999999999);
        $sql = $pdo->pdo->query("INSERT INTO invoice_upgrade (personal_id,username,pedido,descricao,date,status,price_now,patrocinador) VALUES('$row->personal_id','$row->username','$pedido','Renewal invoice','$date','Pending','$kit->price_btc','$row->patrocinador')");
        ?>
        <script>window.location = 'invoice'</script>
    <?php
    }
}

if(isset($_POST['renovar-saldo'])){
$valor = $kit->price_btc;
    $data = date("Y-m-d");
    if($row->renovacao >= $valor){

        $date = date("Y-m-d");
        $data_renovar = date('Y-m-d', strtotime("+6 days", strtotime($date)));
        $sql = $pdo->pdo->query("UPDATE invoice_upgrade SET status='Payd' WHERE username='$row->username' AND descricao='Renewal invoice'");

      //  $sql = $pdo->pdo->query("UPDATE extrato SET status='Payd' WHERE username='$row->username'");
        $pdo->pdo->query("DELETE FROM withdraw WHERE username='$row->username' AND descricao='withdrawal request'");
        $pdo->pdo->query("INSERT INTO extrato (personal_id,username,descricao,data,valor,status) VALUES('$row->personal_id','$row->patrocinador','Pagamento de Renovação com saldo','$data','$valor','Payd')");
        $sql3 = $pdo->pdo->query("UPDATE financeiro SET status='Ativo' WHERE username='$row->username'");
        $pdo->pdo->query("UPDATE financeiro SET renovacao=renovacao-'$valor' WHERE username='$row->username'");

        ?>
        <script>
            alert("Congratulations, you renewed your account! "),window.location='index';
        </script>
    <?php
    }else{
        ?>
        <script>
            alert("You have no balance to renew your account!"),window.location='index';
        </script>
    <?php
    }


}
if(isset($_POST['atv'])){
if($row->sacar == "On"){
if($row->status == "Ativo"){
    if(md5($_POST['senha']) === $row->password){
        if($row->saldo >= $_POST['atv']){
            $valor_final = $_POST['atv'];
            $sql2 = $pdo->pdo->query("SELECT * FROM invoice_upgrade WHERE pedido='$_POST[pedido]'");
            if($sql2->rowCount()>0) {
                $res = $sql2->fetchAll(PDO::FETCH_OBJ);

                foreach ($res as $row2) {

                    $valor = $_POST['atv'];
                    $data = date("Y-m-d");

                    $pdo->pdo->query("UPDATE financeiro SET plan='$_POST[kit]',status='Ativo' WHERE personal_id='$row2->personal_id' ");
                    $pdo->pdo->query("UPDATE financeiro SET saldo=saldo-'$valor_final',status='Ativo' WHERE username='$row->username' ");
                    $pdo->pdo->query("UPDATE invoice_upgrade SET status='Payd' WHERE pedido='$_POST[pedido]' ");
                    $pdo->pdo->query("UPDATE extrato SET status='Payd' WHERE pedido_id='$_POST[pedido]' ");

                        $pdo->pdo->query("INSERT INTO extrato (personal_id,username,descricao,data,valor,status) VALUES('$row->personal_id','$row->username','Pagamento de Fatura com saldo','$data','$valor_final','Payd')");

                    $_Function->AtivarUpgrade($valor, $row2->patrocinador,$row2->personal_id,$row2->username,$row2->plan_up,$row2->pedido);




                    ?>
                    <script>alert("Active users successfully"),window.location='atvsaldo'</script>
                    <?php

            }
            }
        }else{
            ?>
            <script>alert("Your balance is not enough ")</script>
        <?php
        }


    }else{
        ?>
        <script>alert("Password you entered is invalid ")</script>
    <?php
    }
}else{
    ?>
    <script>alert("You need to be active to perform this action.")</script>
<?php
}
}else{
    ?>
    <script>alert("You must be Qualified to perform this action")</script>
<?php
}
}
if(isset($_POST['set-saque'])) {
if($saques_dia  < 1){
    if($row->status == 'Ativo') {

        if ($admin->saque == "Liberado") {

            if ($row->password === md5($_POST['password'])) {

                if($row->plan >1){

                    if($row->saldo >= $_POST['valor']){

                        if($_POST['valor']>= $admin->min_saque){


                            if($_POST['valor'] >0){

                                $total_ganho2 = $_POST['valor']+$total_ganho2;
                                if($total_ganho2 < $valor_renovar){
                               // $_Function->AtualizarBanco($row->personal_id, $_POST['banco'],$_POST['agencia'],$_POST['conta'],$_POST['tipo'],$_POST['cpf']);
                                $_Function->AtualizarWallet($row->personal_id,$_POST['wallet']);
                                $_Function->SolicitarSaque($row->personal_id, $_POST['valor'], $row->username, $_POST['wallet'],$block_io);

                                }else{
                                    ?>
                                    <script>alert("You can not get more value than your account limit for renewal try a lower value!")</script>
                                <?php
                                }
                            }else{
                                ?>
                                <script>alert("O valor Minimo para retirar é  <?php echo number_format($admin->min_saque,8,'.','.')?> | Bitcoins ")</script>
                            <?php
                            }
                        }else{
                            ?>
                            <script>alert("The minimum value to make a withdrawal is <?php echo number_format($admin->min_saque,8,'.','.')?> | Bitcoins ")</script>
                        <?php
                        }
                    }else{
                        ?>
                        <script>alert("Insufficient funds")</script>
                    <?php
                    }
                }else{
                    ?>
                    <script>alert("You can not make withdrawals in the FREE plan")</script>
                <?php
                }


            } else {
                ?>
                <script>alert("Senha inválida")</script>
            <?php
            }
            ?>
        <?php

        }else {
            ?>
            <script>alert("The service will be available soon!")</script>
        <?php
        }
    }else{

        ?>
        <script>alert("You need to renew your account to make withdrawals."), window.location = 'index'</script>
    <?php
    }


}else{
    ?>
    <script>alert("You already requested a service today, Please try the next day!"), window.location = 'index'</script>
<?php
}
}


if(isset($_POST['set-settings'])) {


    $Pin = md5($_POST['password']);

    if ($Pin == $row->password) {


        if (isset($_POST['wallet']) != "") {
            $newWallet = $_POST['wallet'];
            $_Function->AtualizarWallet($row->personal_id, $newWallet);
        }
        if (isset($_POST['banco'])) {
            $_Function->AtualizarBanco($row->personal_id, $_POST['banco'],$_POST['agencia'],$_POST['conta'],$_POST['tipo'],$_POST['cpf']);
        }

        // if (isset($_POST['pin']) !="") {
        //   $NewPin = $_POST['pin'];
        // $_Function->AtualizarPin($row->personal_id, md5($NewPin));
        //}

        ?>
        <script>alert("Your data has been successfully saved!"), window.location = 'settings'</script>
    <?php
    }else{
        ?>
        <script>alert("Invalid Password"), window.location = 'settings'</script>
    <?php
    }

}


if(isset($_POST['set-gerateInvoice'])){

    if($_POST['QTD'] >= 0.03530000){


        $_Function->GerarInvoice($row->personal_id,$_POST['QTD'],$_POST['TOTAL'],$row->username);


    }else{
        ?>
        <script>alert("The minimum recharge value is 0.03530000")</script>
    <?php

    }



}

if(isset($_GET['Delete'])){

    $_Function->DeletarPedido($row->personal_id,$_GET['Delete']);


}


if(isset($_POST['set-newpass'])){
    $pass = md5($_POST['password']);
    if($pass === $row->password){

        if($_POST['cpass'] === $_POST['newpass']){



            $_Function->SetNewPass($row->personal_id,md5($_POST['newpass']));
            ?>
            <script>alert("Password changed successfully !")</script>
        <?php



        }else{
            ?>
            <script>alert("Passwords do not match")</script>
        <?php
        }


    }else{
        ?>
        <script>alert("invalid password")</script>
    <?php
    }

}



if(isset($_POST['confirm_wallet'])){

    if(isset($_POST['wallet_reference'])){
        $wallet = $_POST['wallet_reference'];
    }else{
        $wallet = "Nao infomrado";
    }
    $_Function->ConfirmPay($wallet,$row->personal_id,$_POST['invoice'],$_POST['valor']);

}





?>
