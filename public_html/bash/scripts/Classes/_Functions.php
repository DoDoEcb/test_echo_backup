<?php
/**
 * Created by PhpStorm.
 * User: elifas
 * Date: 08/11/16
 * Time: 02:36
 */
include_once("../scripts/Classes/connection/connect.php");
class _Functions
{

    // varável que percorre a Class de conexão com o banco de dados.
    private $pdo;

    // Função que faz a construção da classe de conexão com o banco de dados.
    function __construct()
    {
        $this->con = new Connection;
        $this->pdo = $this->con->Connect();
    }


    function ContarUsuarios($status)
    {

        $sql = $this->pdo->query("SELECT COUNT(username) as user_total FROM financeiro WHERE status='$status' ");
        $res = $sql->fetch(PDO::FETCH_OBJ);
        if ($sql->rowCount() > 0) {
            return $res->user_total;
        } else {
            return 0;
        }

    }

    function ContarOnline()
    {

        $sql = $this->pdo->query("SELECT COUNT(username) as user_total FROM usuarios WHERE chat_status='Onlinne' ");
        $res = $sql->fetch(PDO::FETCH_OBJ);
        if ($sql->rowCount() > 0) {
            return $res->user_total;
        } else {
            return 0;
        }
    }

    function SomarEntrada($price)
    {
        $sql = $this->pdo->query("SELECT SUM(p.$price) as entrada_dolar FROM financeiro as f INNER JOIN plan as p on f.plan=p.id ");
        $res = $sql->fetch(PDO::FETCH_OBJ);
        if ($sql->rowCount() > 0) {
            return $res->entrada_dolar;
        } else {
            return 0;
        }
    }


    function Retirada($status)
    {
        $sql = $this->pdo->query("SELECT SUM(valor) as total_retirada FROM withdraw WHERE status='$status' ");
        $res = $sql->fetch(PDO::FETCH_OBJ);
        if ($sql->rowCount() > 0) {
            return $res->total_retirada;
        } else {
            return 0;
        }


    }

    function ContaPlan($plan)
    {

        $sql = $this->pdo->query("SELECT COUNT(p.name) as QTD_plan FROM financeiro as f INNER JOIN plan as p on f.plan=p.id WHERE p.name='$plan' ");
        $res = $sql->fetch(PDO::FETCH_OBJ);
        if ($sql->rowCount() > 0) {
            return $res->QTD_plan;
        } else {
            return 0;
        }
    }


    function Admin(){

        $sql =$this->pdo->query("SELECT * FROM admin");
        $res = $sql->fetchAll(PDO::FETCH_OBJ);

        foreach($res as $row){

            return $row;
        }

    }

    function EditarUsuario($data_registro, $name, $username, $email, $patrocinador, $adress, $cpf, $phone, $ip, $referencia)
    {

        $this->pdo->query("UPDATE usuarios SET name='$name',username='$username',email='$email',patrocinador='$patrocinador',adress='$adress',cpf='$cpf',phone='$phone',adress_ip='$ip' WHERE username='$referencia' ");


    }

    function EditarUsuario2($saldo, $saldo_ind, $plan, $wallet, $status, $referencia)
    {

        $this->pdo->query("UPDATE financeiro SET saldo='$saldo',saldo_ind='$saldo_ind',plan='$plan',status='$status' WHERE username='$referencia' ");
        $this->pdo->query("UPDATE usuarios SET wallet='$wallet' WHERE username='$referencia' ");


    }

    function EditarSenha($senha, $referencia)
    {

        $this->pdo->query("UPDATE usuarios SET password='$senha' WHERE username='$referencia' ");


    }

    function EditarPin($pin, $referencia)
    {

        $this->pdo->query("UPDATE usuarios SET pin='$pin' WHERE username='$referencia' ");


    }

    function ActiveUsuario($username)
    {


        $sql = $this->pdo->prepare("UPDATE financeiro SET status=:sts WHERE username=:username");
        $smt = array(
            ":sts" => 'Ativo',
            "username" => $username,
        );
        $sql->execute($smt);


    }

    function BloquearUsuario($username, $sts)
    {


        $sql = $this->pdo->prepare("UPDATE financeiro SET block=:sts WHERE username=:username");
        $smt = array(
            ":sts" => $sts,
            "username" => $username,
        );
        $sql->execute($smt);


    }

    function DeletarUsuario($username)
    {


        $sql = $this->pdo->prepare("DELETE FROM usuarios WHERE username=:username");
        $sql2 = $this->pdo->prepare("DELETE FROM financeiro WHERE username=:username");
        $sql3 = $this->pdo->prepare("DELETE FROM extrato WHERE username=:username");
        $sql4 = $this->pdo->prepare("DELETE FROM renovacao WHERE username=:username");
        $sql5 = $this->pdo->prepare("DELETE FROM invoice_upgrade WHERE username=:username");
        $sql6 = $this->pdo->prepare("DELETE FROM withdraw WHERE username=:username");
        $smt = array(
            "username" => $username,
        );
        $sql->execute($smt);
        $sql2->execute($smt);
        $sql3->execute($smt);
        $sql4->execute($smt);
        $sql6->execute($smt);


    }

    function SetPayWithdraw($id,$pedido,$valor,$username)
    {

        $sql2 = $this->pdo->query("UPDATE withdraw SET status='Payd' WHERE id='$id'");
        $sql = $this->pdo->query("UPDATE renovacao SET saldo_renovar=saldo_renovar+'$valor' WHERE username='$username'");
        $this->pdo->query("UPDATE extrato SET status='Payd' WHERE pedido_id='$pedido'");

    }

    function ConfirmRenovar($pedido_id, $username,$saldo,$valor,$patrocinador)
    {

        $date = date("Y-m-d");
        $data_renovar = date('Y-m-d', strtotime("+6 days", strtotime($date)));
        $sql = $this->pdo->query("UPDATE invoice_upgrade SET status='Payd' WHERE pedido='$pedido_id'");

        $sql = $this->pdo->query("UPDATE extrato SET status='Payd' WHERE pedido_id='$pedido_id'");

        $sql2 = $this->pdo->query("UPDATE renovacao SET data='$date', data_renovar='$data_renovar',saldo_renovar=saldo_renovar+'$saldo' WHERE username='$username'");
        $this->pdo->query("DELETE FROM withdraw WHERE username='$username' AND descricao='withdrawal request'");

        $sql3 = $this->pdo->query("UPDATE financeiro SET status='Ativo' WHERE username='$username'");


    }

    function Qualificar($username,$status){

        $this->pdo->query("UPDATE usuarios SET sacar='$status' WHERE username='$username'");

    }
    function EstornarSaque($pedido,$motivo){

        $sql =$this->pdo->query("SELECT * FROM withdraw WHERE pedido='$pedido'");
        $res = $sql->fetchAll(PDO::FETCH_OBJ);

        foreach($res as $row){


            $this->pdo->query("UPDATE extrato SET status='Estornado',descricao='$motivo' WHERE pedido_id='$pedido'");
            $this->pdo->query("UPDATE financeiro SET saldo=saldo+'$row->valor' WHERE username='$row->username'");
            $this->pdo->query("DELETE FROM  withdraw  WHERE username='$row->username' AND  pedido='$pedido'");

            $sql2 = $this->pdo->prepare("UPDATE withdraw SET status=:status WHERE pedido=:id AND username=:username");
            $smt2 = array(
                ":status" => 'reversed',
                ":username" => $row->username,
                ":id" => $pedido,

            );
            $sql2->execute($smt2);

            ?>
            <script>
                alert("Saque Estornado com sucesso  do usuario : <?php echo $row->username?> no valor de <?php echo $row->valor?>"),window.location='withdrawal-request';
            </script>
        <?php
        }
    }


    function BuscarPlanos($nameplan)
    {


        $sql = $this->pdo->query("SELECT * FROM plan WHERE name='$nameplan'");
        $res = $sql->fetchAll(PDO::FETCH_OBJ);
        foreach ($res as $row) {

            return $row;
        }

    }

    function BuscarInfo($patrocinador)
    {

        $sql = $this->pdo->query("SELECT * FROM usuarios WHERE username='$patrocinador'");
        $res = $sql->fetchAll(PDO::FETCH_OBJ);
        foreach ($res as $row) {

            return $row;
        }

    }


    function AtivarUpgrade($valor, $patrocinador, $personal_id, $username, $plan_up, $pedido_id)
    {


        $kit = $this->BuscarPlanos($plan_up);

        $this->pdo->query("UPDATE financeiro SET plan='$kit->id',status='Ativo' WHERE personal_id='$personal_id' ");
        $date = date("Y-m-d");
        $data_renovar = date('Y-m-d', strtotime("+6 days",strtotime($date)));
        $this->pdo->query("UPDATE invoice_upgrade SET status='Payd' WHERE pedido='$pedido_id' ");
        $this->pdo->query("UPDATE extrato SET status='Payd' WHERE pedido_id='$pedido_id' ");



        if($kit->id !=2){

            if (!empty($patrocinador)) {
                $comissao_dirteta = $valor * 10   / 100;
                $sql = $this->pdo->query("SELECT * FROM usuarios WHERE username='$patrocinador'");
                if ($sql->rowCount() > 0) {
                    $res = $sql->fetch(PDO::FETCH_OBJ);
                    $data = date("Y-m-d");
                    $this->pdo->query("UPDATE financeiro SET saldo_ind=saldo_ind+'$comissao_dirteta',saldo=saldo+'$comissao_dirteta' WHERE username='$patrocinador' AND status='Ativo' ");
                    $this->pdo->query("INSERT INTO extrato (personal_id,username,descricao,data,valor,status) VALUES('$res->id','$patrocinador','Comissão Direta : $username','$data','$comissao_dirteta','Payd')");


                    if (!empty($res->patrocinador)) {
                        $comissao_indirteta = $valor * 8 / 100;
                        $sql = $this->pdo->query("SELECT * FROM usuarios WHERE username='$res->patrocinador'");
                        if ($sql->rowCount() > 0) {
                            $res2 = $sql->fetch(PDO::FETCH_OBJ);
                            $data = date("Y-m-d");
                            $this->pdo->query("UPDATE financeiro SET saldo_ind=saldo_ind+'$comissao_indirteta',saldo=saldo+'$comissao_indirteta' WHERE username='$res->patrocinador' AND status='Ativo' ");
                            $this->pdo->query("INSERT INTO extrato (personal_id,username,descricao,data,valor,status) VALUES('$res2->id','$res->patrocinador','Comissão Indireta : $username','$data','$comissao_indirteta','Payd')");


                            if (!empty($res2->patrocinador)) {
                                $comissao_indirteta2 = $valor * 5 / 100;
                                $sql = $this->pdo->query("SELECT * FROM usuarios WHERE username='$res2->patrocinador'");
                                if ($sql->rowCount() > 0) {
                                    $res3 = $sql->fetch(PDO::FETCH_OBJ);
                                    $data = date("Y-m-d");
                                    $this->pdo->query("UPDATE financeiro SET saldo_ind=saldo_ind+'$comissao_indirteta2',saldo=saldo+'$comissao_indirteta2' WHERE username='$res2->patrocinador' AND status='Ativo' ");
                                    $this->pdo->query("INSERT INTO extrato (personal_id,username,descricao,data,valor,status) VALUES('$res3->id','$res2->patrocinador','Comissão Indireta : $username','$data','$comissao_indirteta2','Payd')");



                                    if (!empty($res3->patrocinador)) {
                                        $comissao_indirteta3 = $valor * 1 / 100;
                                        $sql = $this->pdo->query("SELECT * FROM usuarios WHERE username='$res3->patrocinador'");
                                        if ($sql->rowCount() > 0) {
                                            $res4 = $sql->fetch(PDO::FETCH_OBJ);
                                            $data = date("Y-m-d");
                                            $this->pdo->query("UPDATE financeiro SET saldo_ind=saldo_ind+'$comissao_indirteta3',saldo=saldo+'$comissao_indirteta3' WHERE username='$res3->patrocinador' AND status='Ativo' ");
                                            $this->pdo->query("INSERT INTO extrato (personal_id,username,descricao,data,valor,status) VALUES('$res4->id','$res3->patrocinador','Comissão Indireta : $username','$data','$comissao_indirteta3','Payd')");





                                            if (!empty($res4->patrocinador)) {
                                                $comissao_indirteta4 = $valor * 1 / 100;
                                                $sql = $this->pdo->query("SELECT * FROM usuarios WHERE username='$res4->patrocinador'");
                                                if ($sql->rowCount() > 0) {
                                                    $res5 = $sql->fetch(PDO::FETCH_OBJ);
                                                    $data = date("Y-m-d");
                                                    $this->pdo->query("UPDATE financeiro SET saldo_ind=saldo_ind+'$comissao_indirteta4',saldo=saldo+'$comissao_indirteta4' WHERE username='$res4->patrocinador' AND status='Ativo' ");
                                                    $this->pdo->query("INSERT INTO extrato (personal_id,username,descricao,data,valor,status) VALUES('$res5->id','$res4->patrocinador','Comissão Indireta : $username','$data','$comissao_indirteta4','Payd')");


                                                    if (!empty($res5->patrocinador)) {
                                                        $comissao_indirteta5 = $valor * 1 / 100;
                                                        $sql = $this->pdo->query("SELECT * FROM usuarios WHERE username='$res5->patrocinador'");
                                                        if ($sql->rowCount() > 0) {
                                                            $res6 = $sql->fetch(PDO::FETCH_OBJ);
                                                            $data = date("Y-m-d");
                                                            $this->pdo->query("UPDATE financeiro SET saldo_ind=saldo_ind+'$comissao_indirteta5',saldo=saldo+'$comissao_indirteta5' WHERE username='$res5->patrocinador' AND status='Ativo' ");
                                                            $this->pdo->query("INSERT INTO extrato (personal_id,username,descricao,data,valor,status) VALUES('$res6->id','$res5->patrocinador','Comissão Indireta : $username','$data','$comissao_indirteta4','Payd')");


                                                            if (!empty($res6->patrocinador)) {
                                                                $comissao_indirteta6 = $valor * 1 / 100;
                                                                $sql = $this->pdo->query("SELECT * FROM usuarios WHERE username='$res6->patrocinador'");
                                                                if ($sql->rowCount() > 0) {
                                                                    $res7 = $sql->fetch(PDO::FETCH_OBJ);
                                                                    $data = date("Y-m-d");
                                                                    $this->pdo->query("UPDATE financeiro SET saldo_ind=saldo_ind+'$comissao_indirteta6',saldo=saldo+'$comissao_indirteta6' WHERE username='$res6->patrocinador' AND status='Ativo' ");
                                                                    $this->pdo->query("INSERT INTO extrato (personal_id,username,descricao,data,valor,status) VALUES('$res7->id','$res6->patrocinador','Comissão Indireta : $username','$data','$comissao_indirteta5','Payd')");



                                                                    if (!empty($res7->patrocinador)) {
                                                                        $comissao_indirteta7 = $valor * 1 / 100;
                                                                        $sql = $this->pdo->query("SELECT * FROM usuarios WHERE username='$res7->patrocinador'");
                                                                        if ($sql->rowCount() > 0) {
                                                                            $res8 = $sql->fetch(PDO::FETCH_OBJ);
                                                                            $data = date("Y-m-d");
                                                                            $this->pdo->query("UPDATE financeiro SET saldo_ind=saldo_ind+'$comissao_indirteta6',saldo=saldo+'$comissao_indirteta6' WHERE username='$res7->patrocinador' AND status='Ativo' ");
                                                                            $this->pdo->query("INSERT INTO extrato (personal_id,username,descricao,data,valor,status) VALUES('$res8->id','$res7->patrocinador','Comissão Indireta : $username','$data','$comissao_indirteta5','Payd')");

                                                                        }
                                                                    }

                                                                }
                                                            }

                                                        }
                                                    }

                                                }
                                            }
                                        }


                                    }
                                }
                            }
                        }



                    }
                }



            }
        }



    }
    }