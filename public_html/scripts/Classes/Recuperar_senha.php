<?php
/**
 * Created by PhpStorm.
 * User: Leo - TI
 * Date: 7/19/2016
 * Time: 3:49 AM
 */

require_once("connection/connect.php");
class Recuperar_senha {

    // varável que percorre a Class de conexão com o banco de dados.
    private $pdo;

// Função que faz a construção da classe de conexão com o banco de dados.
    function __construct() {
        $this->con = new Connection;
        $this->pdo = $this->con->Connect();
    }



    function _senha($personal_id){
        require_once("class/class.phpmailer.php");
        require_once("class/class.smtp.php");
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
                    $mail->AddReplyTo($row->email, $row->username); //Seu e-mail
                    $mail->Subject = 'Recupera minha senha ';//Assunto do e-mail


//Define os destinatário(s)
//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
                    $mail->AddAddress($row->email, 'Recupera minha senha'); // Configura o email de destino e o Título da mensagem

//Campos abaixo são opcionais
//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//$mail->AddCC('destinarario@dominio.com.br', 'Destinatario'); // Copia
//$mail->AddBCC('destinatario_oculto@dominio.com.br', 'Destinatario2`'); // Cópia Oculta
//$mail->AddAttachment('images/phpmailer.gif');      // Adicionar um anexo


//Define o corpo do email
                    $mail->MsgHTML(" Olá , Sr(a) $row->name , Clicando no link abaixo você pode redefinir sua senha , Atençao caso está solicitação não foi feita por você entre em contato junto a empresa <br><a href='EmpireBits.com/nova_senha.php?token=$row->token'>Recuperar Senha</a> " );
                    ?>
                    <script>alert("Foi enviado um link no email <?php echo $row->email ?>, com sucesso!")</script>
<?php
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

}