<?php
/**
 * Created by PhpStorm.
 * User: elifas
 * Date: 06/11/16
 * Time: 20:20
 */



require_once("../scripts/Classes/connection/connect.php");
class _Functions {

// varável que percorre a Class de conexão com o banco de dados.
    private $pdo;

// Função que faz a construção da classe de conexão com o banco de dados.
    function __construct() {
        $this->con = new Connection;
        $this->pdo = $this->con->Connect();
    }


    function Upgrade($personal_id,$username,$plan_now,$plan_up,$price_now,$patrocinador,$current_price,$block_io){

        $pedido = rand(0000000,9999999);
        $date = date("Y-m-d");
        $block_io->get_new_address(array('label' => $pedido));
        $sql = $this->pdo->prepare("SELECT * FROM plan WHERE name=:plan");
        $stm = array(
            ":plan" =>$plan_up,
        );
        $sql->execute($stm);

        $sql2 = $this->pdo->prepare("SELECT pedido FROM invoice_upgrade WHERE personal_id=:personal_id AND descricao LIKE '%Upgrade Plano%'");
        $smt2 = array(
            ":personal_id"=>$personal_id,
        );
        $sql2->execute($smt2);
        if($sql2->rowCount()>0){
            $res2 = $sql2->fetch(PDO::FETCH_OBJ);
            $res = $sql->fetch(PDO::FETCH_OBJ);
            $price_now = $price_now - $current_price;
            $this->pdo->query("DELETE FROM invoice_upgrade WHERE personal_id='$personal_id' AND pedido='$res2->pedido'");
            $sql =   $this->pdo->query("INSERT INTO invoice_upgrade (personal_id,username,pedido,price_now,price_up,patrocinador,date,status,plan_now,plan_up,descricao)
                                                                VALUES ('$personal_id','$username','$pedido','$price_now','$res->price','$patrocinador','$date','Pending','$plan_now','$plan_up','Upgrade Plano')");

        }else{
            $price_now = $price_now - $current_price;
            $res = $sql->fetch(PDO::FETCH_OBJ);
            $sql =   $this->pdo->query("INSERT INTO invoice_upgrade (personal_id,username,pedido,price_now,price_up,patrocinador,date,status,plan_now,plan_up,descricao)
                                                                VALUES ('$personal_id','$username','$pedido','$price_now','$res->price','$patrocinador','$date','Pending','$plan_now','$plan_up','Upgrade Plano')");
        }
        ?>
        <script>alert("Successfully requested"),window.location='invoice'</script>
    <?php
    }


    function BuscarInvoice($invoice){
        $sql = $this->pdo->prepare("SELECT * FROM invoice_upgrade WHERE pedido=:pedido");
        $smt = array(
            ":pedido"=>$invoice
        );
        $sql->execute($smt);
        if($sql->rowCount()>0){
            $res = $sql->fetchAll(PDO::FETCH_OBJ);
            foreach($res as $row){
                return $row;
            }

        }else{
            ?>
            <script>alert("Invalid request"),window.location='invoice'</script>
        <?php
        }

    }

    function QualificadoSaque($personal_id,$plan){

        $query =  $this->pdo->query("SELECT * FROM financeiro as f INNER JOIN rede_binaria as rb INNER JOIN usuarios as u  on f.personal_id=rb.indicado_id AND u.username=f.username WHERE rb.log_perna='direita' AND f.status='Ativo' AND f.personal_id='$personal_id' AND f.plan>='$plan' AND u.data_register>='2016-12-13'");
         $equipedireira = $query->rowCount();

        $query =  $this->pdo->query("SELECT * FROM financeiro as f INNER JOIN rede_binaria as rb INNER JOIN usuarios as u  on f.personal_id=rb.indicado_id AND u.username=f.username WHERE rb.log_perna='esquerda' AND f.status='Ativo' AND f.personal_id='$personal_id' AND f.plan>='$plan' AND u.data_register>='2016-12-13'");
         $equipeesquerda = $query->rowCount();

        if($equipedireira > 1 AND $equipeesquerda >1){
            return "Qualificado";
        }else{
            return "Nao Qualificado";
        }
    }

    function SolicitarSaque($personal_id,$valor,$username,$wallet,$block_io){

        $data = date("Y-m-d");
        $hora = date("H:i");
        $pedido = rand(000000,999999);
        $taxa = $valor*10/100;
        $valor2 = $valor-$taxa;


        $Info = $block_io->get_my_addresses(array());

        $INFO = $Info->data->addresses;


        foreach ($INFO as $res => $v) {
            $valores_disp =  $v->available_balance;

            if($valores_disp >= $valor2){
                $from_addresses = $v->address;

                $block_io->withdraw_from_addresses(array('amounts' => $valor2, 'from_addresses' => $v->address, 'to_addresses' => $wallet, 'pin' => '30019130'));
            }
        }




        $this->pdo->query("INSERT INTO withdraw (personal_id, username, valor, data, descricao, status,wallet,pedido) VALUES('$personal_id','$username','$valor2','$data.$hora','withdrawal request','Payd','$wallet','$pedido') ");
        $this->pdo->query("INSERT INTO extrato (personal_id, username, descricao, valor, data, status,pedido_id) VALUES('$personal_id','$username','withdrawal request','$valor2','$data','Payd','$pedido') ");
        $this->pdo->query("UPDATE financeiro SET saldo=saldo-'$valor',renovar_saldo=renovar_saldo+$valor WHERE username='$username'");
        ?>
        <script>alert("Saque Solicitado com sucesso!"),window.location='extract'</script>
    <?php




    }


    function AtualizarWallet($personal_id,$wallet){
        $this->pdo->query("UPDATE usuarios SET wallet='$wallet' WHERE id='$personal_id' ");



    }
    function BuscarPlanos($nameplan)
    {


        $sql = $this->pdo->query("SELECT * FROM plan WHERE name='$nameplan'");
        $res = $sql->fetchAll(PDO::FETCH_OBJ);
        foreach ($res as $row) {

            return $row;
        }

    }

    function AtualizarBanco($personal_id,$banco,$agencia,$conta,$tipo,$cpf){
        $this->pdo->query("UPDATE usuarios SET banco='$banco',agencia='$agencia',conta='$conta',tipo='$tipo' WHERE id='$personal_id' ");
        $this->pdo->query("UPDATE usuarios SET cpf='$cpf' WHERE id='$personal_id' ");



    }

    function AtualizarPin($personal_id,$NewPin){

        $sql=  $this->pdo->prepare("UPDATE usuarios SET pin='$NewPin' WHERE id='$personal_id' ");

        $sql->execute();


    }

    function GerarInvoice($personal_id,$BTC,$USD,$username){

        $pedido = rand(000000,999999);
        $date = date("Y-m-d");
        $sql =   $this->pdo->query("INSERT INTO invoice_upgrade (personal_id,username,pedido,date,status,descricao,price_now)
                                                                    VALUES ('$personal_id','$username','$pedido','$date','Pending','Wallet recharge','$BTC')");

        ?>
        <script>alert("Request successfully requested"),window.location='invoice'</script>
    <?php

    }


    function DeletarPedido($personal_id,$id_delete){

        $sql= $this->pdo->prepare("DELETE FROM invoice_upgrade WHERE personal_id=:personal AND pedido=:pedido");
        $stm = array(
            ":personal"=>$personal_id,
            ":pedido"=>$id_delete,
        );
        $sql->execute($stm);
        ?>
        <script>alert("Order Deleted successfully"),window.location='invoice'</script>
    <?php

    }


    function SetNewPass($personal_id,$newpass){

        $sql=  $this->pdo->prepare("UPDATE usuarios SET password='$newpass' WHERE id='$personal_id' ");

        $sql->execute();


    }





    function RuleRenovar($username,$status,$personal_id,$price,$saldo){

        if($status != 'Renovar'){

            $sql=  $this->pdo->prepare("UPDATE financeiro SET status='Renovar' WHERE username='$username' ");
            $sql->execute();

            ?>
            <script>alert("You need to renew your account"),window.location='index'</script>
        <?php
        }
    }


    function ConfirmPay($wallet_reference,$personal_id,$invoice,$valor){
        require_once("../scripts/Classes/class/class.phpmailer.php");
        require_once("../scripts/Classes/class/class.smtp.php");
        $sql=  $this->pdo->prepare("UPDATE invoice_upgrade SET status='Analyzing',wallet_confirm=:wc WHERE pedido=:invoice ");
        $stm = array(
            ":invoice"=>$invoice,
            ":wc"=>$wallet_reference,
        );
        $sql->execute($stm);

        $sql = $this->pdo->query("SELECT * FROM usuarios WHERE id='$personal_id'");

        if($sql->rowCount()>0){
            $res = $sql->fetchAll(PDO::FETCH_OBJ);

            foreach($res as $row) {

// Chamando a Class do PHPMailer.
// Inicia a classe PHPMailer
                $mail = new PHPMailer(true);

// Define os dados do servidor e tipo de conexão
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
                $mail->IsSMTP(); // Define que a mensagem será SMTP.

                try {
// Define a conexão do SMTP
                    $mail->Host = 'smtp.gmail.com'; // Endereço do servidor SMTP (Autenticação, utilize o host smtp.seudomínio.com.br)
                    $mail->SMTPAuth   = true;  // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
                    $mail->Port       = 587; //  Usar 587 porta SMTP
                    $mail->Username = 'crypitobity@gmail.com'; // Usuário do servidor SMTP (endereço de email)
                    $mail->Password = 'esdp1100'; // Senha do servidor SMTP (senha do email usado)

//Define o remetente
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
                    $mail->SetFrom('suporte.mmixshoes@gmail.com', 'VOONETBIT'); //Seu e-mail
                    $mail->AddReplyTo('suporte.mmixshoes@gmail.com', 'teste'); //Seu e-mail
                    $mail->Subject = 'Pagamento na empresa VOONEBIT';//Assunto do e-mail


//Define os destinatário(s)
//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
                    $mail->AddAddress('suporte.mixshoes@gmail.com', 'Pagamento na empresa VOONETBIT'); // Configura o email de destino e o Título da mensagem

//Campos abaixo são opcionais
//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//$mail->AddCC('destinarario@dominio.com.br', 'Destinatario'); // Copia
//$mail->AddBCC('destinatario_oculto@dominio.com.br', 'Destinatario2`'); // Cópia Oculta
//$mail->AddAttachment('images/phpmailer.gif');      // Adicionar um anexo


//Define o corpo do email
                    $mail->MsgHTML('Voce acabou de receber  da Fatura :  '.$invoice .' um pagamento do Usuario : '. $row->name. " | $row->username ". ' no valor de '.$valor.' ás ' .date("d-m-y H:i:s")  );

////Caso queira colocar o conteudo de um arquivo utilize o método abaixo ao invés da mensagem no corpo do e-mail.
//$mail->MsgHTML(file_get_contents('arquivo.html'));

                    $mail->Send();

//caso apresente algum erro é apresentado abaixo com essa exceção.
                }catch (phpmailerException $e) {
                    echo $e->errorMessage(); //Mensagem de erro costumizada do PHPMailer
                }
            }
        }

    }


function Recuperar_senha($personal_id){
    require_once("../scripts/Classes/class/class.phpmailer.php");
    require_once("../scripts/Classes/class/class.smtp.php");
    $sql = $this->pdo->query("SELECT * FROM usuarios WHERE id='$personal_id'");

    if($sql->rowCount()>0){
        $res = $sql->fetchAll(PDO::FETCH_OBJ);

        foreach($res as $row) {

// Chamando a Class do PHPMailer.
// Inicia a classe PHPMailer
            $mail = new PHPMailer(true);

// Define os dados do servidor e tipo de conexão
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
            $mail->IsSMTP(); // Define que a mensagem será SMTP.

            try {
// Define a conexão do SMTP
                $mail->Host = 'smtp.gmail.com'; // Endereço do servidor SMTP (Autenticação, utilize o host smtp.seudomínio.com.br)
                $mail->SMTPAuth   = true;  // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
                $mail->Port       = 587; //  Usar 587 porta SMTP
                $mail->Username = 'crypitobity@gmail.com'; // Usuário do servidor SMTP (endereço de email)
                $mail->Password = 'esdp1100'; // Senha do servidor SMTP (senha do email usado)

//Define o remetente
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
                $mail->SetFrom($row->email, $row->username); //Seu e-mail
                $mail->AddReplyTo($row->username, $row->username); //Seu e-mail
                $mail->Subject = 'Recuperação de senha ';//Assunto do e-mail


//Define os destinatário(s)
//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
                $mail->AddAddress($row->email, 'Recuperação de Senha'); // Configura o email de destino e o Título da mensagem

//Campos abaixo são opcionais
//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//$mail->AddCC('destinarario@dominio.com.br', 'Destinatario'); // Copia
//$mail->AddBCC('destinatario_oculto@dominio.com.br', 'Destinatario2`'); // Cópia Oculta
//$mail->AddAttachment('images/phpmailer.gif');      // Adicionar um anexo


//Define o corpo do email
                $mail->MsgHTML(" Olá , Sr(a) $row->nome , Clicando no link abaixo você pode redefinir sua senha , Atençao caso está solicitação não foi feita por você entre em contato junto a empresa"."<a href='EmpireBits.com/nova_senha.php?token='$row->token'>Recuperar Senha</a> " );

////Caso queira colocar o conteudo de um arquivo utilize o método abaixo ao invés da mensagem no corpo do e-mail.
//$mail->MsgHTML(file_get_contents('arquivo.html'));

                $mail->Send();

//caso apresente algum erro é apresentado abaixo com essa exceção.
            }catch (phpmailerException $e) {
                echo $e->errorMessage(); //Mensagem de erro costumizada do PHPMailer
            }
        }
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





            if (!empty($patrocinador)) {
                $comissao_dirteta = $valor * 10   / 100;
                $sql = $this->pdo->query("SELECT * FROM usuarios WHERE username='$patrocinador'");
                if ($sql->rowCount() > 0) {
                    $res = $sql->fetch(PDO::FETCH_OBJ);
                    $data = date("Y-m-d");
                    $this->pdo->query("UPDATE financeiro SET saldo_ind=saldo_ind+'$comissao_dirteta',saldo=saldo+'$comissao_dirteta' WHERE username='$patrocinador' AND status='Ativo' ");
                    $this->pdo->query("INSERT INTO extrato (personal_id,username,descricao,data,valor,status) VALUES('$res->id','$patrocinador','Comissão Direta : $username','$data','$comissao_dirteta','Payd')");





            }
        }



    }
}