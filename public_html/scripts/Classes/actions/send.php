<?php

// Chamando a Class do PHPMailer.
require_once 'class/class.phpmailer.php';
$mail = new PHPMailer(true);

// Importando a class SMTP.
require_once 'class/class.smtp.php';

// Inicia a classe PHPMailer
$mail = new PHPMailer(true);

// Define os dados do servidor e tipo de conexão
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->IsSMTP(); // Define que a mensagem será SMTP.

try {
      // Define a conexão do SMTP
     $mail->Host = 'mail.mochadesenvolvimentos.com'; // Endereço do servidor SMTP (Autenticação, utilize o host smtp.seudomínio.com.br)
     $mail->SMTPAuth   = true;  // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
     $mail->Port       = 587; //  Usar 587 porta SMTP
     $mail->Username = 'contato@mochadesenvolvimentos.com'; // Usuário do servidor SMTP (endereço de email)
     $mail->Password = 'esdp1100'; // Senha do servidor SMTP (senha do email usado)

     //Define o remetente
     // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
     $mail->SetFrom('contato@mochadesenvolvimentos.com', ''); //Seu e-mail
     $mail->AddReplyTo('contato@mochadesenvolvimentos.com', 'Mocha desenvolvimentos Developer'); //Seu e-mail
     $mail->Subject = 'Email de teste';//Assunto do e-mail


     //Define os destinatário(s)
     //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
     $mail->AddAddress('suporte.mixshoes@gmail.com', 'Testando PHPMailer'); // Configura o email de destino e o Título da mensagem

     //Campos abaixo são opcionais
     //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
     //$mail->AddCC('destinarario@dominio.com.br', 'Destinatario'); // Copia
     //$mail->AddBCC('destinatario_oculto@dominio.com.br', 'Destinatario2`'); // Cópia Oculta
     //$mail->AddAttachment('images/phpmailer.gif');      // Adicionar um anexo


     //Define o corpo do email
     $mail->MsgHTML('Olá Senhor, estamos entrando em contato somente para fins de teste da classe PHPMailer!');

     ////Caso queira colocar o conteudo de um arquivo utilize o método abaixo ao invés da mensagem no corpo do e-mail.
     //$mail->MsgHTML(file_get_contents('arquivo.html'));

     $mail->Send();
     echo "Mensagem enviada com sucesso</p>\n";

    //caso apresente algum erro é apresentado abaixo com essa exceção.
    }catch (phpmailerException $e) {
      echo $e->errorMessage(); //Mensagem de erro costumizada do PHPMailer
}

?>
