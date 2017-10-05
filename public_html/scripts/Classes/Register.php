<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
/** ==============================================================================================
 * Sobre a Class UserRegistration.Class
 *
 * Registra todas as informações de novos usuários e usuário já cadastrados.
 */

/** ---------------------------------------------------------------------------------------------
 * @author Elifas Oliveira Patrício <suporte.mixshoes@gmail.com
 * @copy Todos os direitos reservados a Mocha Desenvolvimentos - www.mochadesenvolvimentos.com
 * @since 2016~2020
 * @version 2.0 beta
 * ==============================================================================================
 */


// Chamando Classe que faz a conexão com o banco de dados.
require_once("connection/connect.php");


Class Register {

// varável que percorre a Class de conexão com o banco de dados.
    private $pdo;
    public $id = null;
// Função que faz a construção da classe de conexão com o banco de dados.
    function __construct() {
        $this->con = new Connection;
        $this->pdo = $this->con->Connect();
    }


    function code($pacote){

        $query = $this->pdo->query("SELECT * FROM pacotes WHERE nome_pacote = '$pacote' or code = '$pacote'");
        $res = $query->fetch(PDO::FETCH_ASSOC);
        return $res->code;
    }

    function cadastra_binario($indicacao_id,$personal_id,$perna){
        $perna_original = $perna;
        $indicacao_id = $this->verificaProximaPerna($indicacao_id,$perna);
        if($this->existe_binario($personal_id) == false){

            $this->pdo->query("INSERT INTO rede_binaria (personal_id ,indicado_id,nivel,log_perna,log_perna_cadastro) values ('$indicacao_id' ,  '$personal_id',  1,  '$perna', '$perna_original')")or die(mysql_error());
        }

    }

    function existe_binario($indicado_id){

        $query = $this->pdo->query("SELECT * FROM rede_binaria WHERE indicado_id = '$indicado_id'");
        if($query->rowCount() > 0){
            return true;
        }
        return false;
    }
    function pegaPernaUplines($id){
        $sel = $this->pdo->query("SELECT * FROM dados_acesso_usuario where indicado_id = '$id'");
        if($row = $sel->fetch(PDO::FETCH_ASSOC)){

        }
    }

    function verificaProximaPerna($personal_id,$perna){
        $query = $this->pdo->query("SELECT * FROM rede_binaria WHERE personal_id = '$personal_id' and log_perna = '$perna' ");
        if($query->rowCount() <= 0){

            return $personal_id;
        }else{
            $res = $query->fetch(PDO::FETCH_OBJ);
            return $this->verificaProximaPerna($res->indicado_id,$perna);
        }
    }

    function pegaPernaMenor($perna){

        return $perna;
    }

    function verifica_posicao($id){
        $query = $this->pdo->query("SELECT * FROM rede_binaria WHERE indicado_id = '$id'");
        if($query->rowCount() <= 0){
            return false;
        }

        return true;
    }



    function bonifica($personal_id,$bonus,$saldo_antes,$chave_esquerda,$chave_direita,$perna,$id_usuario,$username,$bonus_esquerda,$bonus_direita){

        $valor_final = $bonus*30/100;
        $saldo_depois = $saldo_antes+$valor_final;

        $Data = date("Y-m-d");
        $this->pdo->query("INSERT INTO binarios_bonificados (personal_id,bonus,saldo_antes,saldo_depois,valor_esquerda,valor_direita,chave_direita,
				chave_esquerda,perna_menor,data) VALUES ('$personal_id','$bonus','$saldo_antes','$saldo_depois','$bonus_esquerda','$bonus_direita','$chave_direita',
				'$chave_esquerda','$perna','$Data') ")or die(mysql_error());

        $this->pdo->query("INSERT INTO extratos (dia, username_ind, historico, pontos, remainder_ind, personal_id,cotadia,valor )
					VALUES('$Data','$username','Bonus de binario perna $perna','$bonus','$saldo_depois','$id_usuario','','$valor_final')")or die(mysql_error());


        $this->pdo->query("UPDATE dados_acesso_usuario SET remainder = '$saldo_depois' where personal_id = '$personal_id'")or die(mysql_error());

    }
    function dados_acesso($personal_id){
        $saldo = $this->pdo->query("SELECT username,id FROM dados_acesso_usuario WHERE personal_id = '$personal_id'");
        $res = $saldo->fetch(PDO::FETCH_OBJ);
        return $res;
    }
    function soma($personal_id){
        $soma = $this->pdo->query("SELECT SUM(bonus) as valor FROM binarios_bonificados WHERE personal_id = '$personal_id'");
        if($soma->rowCount() <= 0){
            return 0;
        }
        $res = $soma->fetch(PDO::FETCH_OBJ);
        return $res->valor;
    }
    function calCulaPerna($chave){
        $chave = $this->removeFalhas($chave);
        $calc = $this->pdo->query("SELECT 1 FROM dados_acesso_usuario
						LEFT JOIN pacotes ON nome_pacote = package OR pacotes.code = package
						WHERE personal_id IN ($chave) and status = 'Ativo' and (package != 'Kit Cadastro' and package != '1') ORDER BY `dados_acesso_usuario`.`personal_id`  ASC")or die(mysql_error());
        if($calc->rowCount() <= 0){
            return 0;
        }

        return $calc->rowCount();
    }
    function calCulaBonus($chave){
        $chave = $this->removeFalhas($chave);
        $calc = $this->pdo->query("SELECT SUM(bonus_binario) as bonus FROM dados_acesso_usuario
						LEFT JOIN pacotes ON nome_pacote = package OR pacotes.code = package
						WHERE personal_id IN ($chave) and status = 'Ativo' and (package != 'Kit Cadastro' and package != '1') ORDER BY `dados_acesso_usuario`.`personal_id`  ASC")or die(mysql_error());
        if($calc->rowCount() <= 0){
            return 0;
        }

        $res = $calc->fetch(PDO::FECH_OBJ);
        return $res->bonus;
    }
    function ehQualificado($personal_id){
        $esq = $this->pdo->query("SELECT * FROM rede_binaria LEFT JOIN dados_acesso_usuario ON rede_binaria.personal_id = dados_acesso_usuario.indicacao_id WHERE rede_binaria.personal_id = '$personal_id' and log_perna = 'esquerda' and dados_acesso_usuario.status = 'Ativo' and (dados_acesso_usuario.package != 'Kit Cadastro' and dados_acesso_usuario.package != '1')");

        if($esq->rowCount() <= 0){
            return false;
        }
        $dir = $this->pdo->query("SELECT * FROM rede_binaria LEFT JOIN dados_acesso_usuario ON rede_binaria.personal_id = dados_acesso_usuario.indicacao_id WHERE rede_binaria.personal_id = '$personal_id' and log_perna = 'direita' and dados_acesso_usuario.status = 'Ativo' and (dados_acesso_usuario.package != 'Kit Cadastro' and dados_acesso_usuario.package != '1')");

        if($dir->rowCount() <= 0){
            return false;
        }
        return true;
    }

    function pegaChaveEsquerda($personal_id){
        $esquerda = $this->pdo->query("SELECT * FROM rede_binaria WHERE personal_id = '$personal_id' and log_perna = 'esquerda'");
        if($esquerda->rowCount() <= 0){
            return "10";
        }else{
            $res = $esquerda->fetchAll(PDO::FETCH_OBJ);
            foreach ($res as $row) {
                return $row->indicado_id.",".$this->pegaChaveEsquerda($row->indicado_id);
            }


        }

    }
    function pegaChaveDireita($personal_id){
        $direita = $this->pdo->query("SELECT indicado_id FROM rede_binaria WHERE personal_id = '$personal_id' and log_perna = 'direita'");
        if($direita->rowCount() <= 0){
            return "10";
        }else{
            $res = $direita->fetchAll(PDO::FETCH_OBJ);
            foreach($res as $row){
                return $row->indicado_id.",".$this->pegaChaveDireita($row->indicado_id);
            }

        }

    }

    function pegaChaveEsquerdaDentro($chave){

        $chave = explode(',',$chave);
        $nchave = "";
        foreach($chave as $k => $v){
            if(is_numeric($v) and $v > 0){
                $nchave .= $v.",";
            }

        }
        $nchave .= "10";

        $chave = $nchave;

        $rede = $this->pdo->query("SELECT * FROM dados_acesso_usuario WHERE indicacao_id IN ($chave)");
        if($rede->rowCount() <= 0){
            return $chave;
        }
        $chave = "";

        while($res = $rede->fetch(PDO::FETCH_OBJ)){
            $chave .= $res->personal_id.",";
        }

        return $chave.",".$this->pegaChaveEsquerdaDentro($chave);
    }
    function pegaChaveDireitaDentro($chave){

        $chave = explode(',',$chave);
        $nchave = "";
        foreach($chave as $k => $v){
            if(is_numeric($v) and $v > 0){
                $nchave .= $v.",";
            }

        }
        $nchave .= "10";

        $chave = $nchave;

        $rede = $this->pdo->query("SELECT * FROM dados_acesso_usuario WHERE indicacao_id IN $chave)");
        if($rede->rowCount() <= 0){
            return $chave;
        }
        $chave = "";

        while($res = $rede->fetch(PDO::FETCH_OBJ)){
            $chave .= $res->personal_id.",";
        }

        return $chave.",".$this->pegaChaveDireitaDentro($chave);
    }

    function pegaChaveDentro($chave){

        $chave = explode(',',$chave);
        $nchave = "";
        foreach($chave as $k => $v){
            if(is_numeric($v) and $v > 0){
                $nchave .= $v.",";
            }

        }
        $nchave .= "10";

        $chave = $nchave;

        $rede = $this->pdo->query("SELECT * FROM dados_acesso_usuario WHERE indicacao_id IN $chave");
        if($rede->rowCount() <= 0){
            return $chave;
        }
        $chave = "";

        while($res = $rede->fetch(PDO::FETCH_OBJ)){
            $chave .= $res->personal_id.",";
        }

        return $chave.",".$this->pegaChaveDentro($chave);
    }

    function removeFalhas($chave){
        $chave = explode(',',$chave);
        $nchave = "";
        foreach($chave as $k => $v){
            if(is_numeric($v) and $v > 0){
                $nchave .= $v.",";
            }

        }
        $chave = $nchave."10";
        return $chave;
    }



// Função que gera novo registro no banco de dados.
    function Cadastro($name,$email,$username,$adress,$phone,$cpf,$pass,$patrocinador,$token,$kit) {
        try {
// Função que gera novo registro no banco de dados.
            $date = date("Y-m-d");
            $data_renovar = date('Y-m-d', strtotime("+30 days",strtotime($date)));
            $ip = $_SERVER["REMOTE_ADDR"];

            $sql = $this->pdo->query("INSERT INTO usuarios (name,email,username,adress,cpf,phone,password,data_register,adress_ip,patrocinador,token)VALUES('$name','$email','$username','$adress','$cpf','$phone','$pass','$date','$ip','$patrocinador','$token')");

            $sql2 = $this->pdo->query("SELECT id FROM usuarios WHERE username='$username'");
            if($sql2->rowCount()>0){
                $res = $sql2->fetchAll(PDO::FETCH_OBJ);
                foreach($res as $row){
                    $sql3 = $this->pdo->query("SELECT * FROM plan WHERE id='$kit'");
                    if($sql3->rowCount()>0) {
                        $ress = $sql3->fetch(PDO::FETCH_OBJ);
                        $this->pdo->query("INSERT INTO financeiro (personal_id,username,saldo,saldo_ind,renovar_saldo,status,plan) VALUES('$row->id','$username','0','0','0','Pendente','1')");
                        $this->pdo->query("INSERT INTO renovacao (personal_id,username,data,data_renovar,saldo_renovar) VALUES('$row->id','$username','$date','$data_renovar','0')");

                        $this->AtivarBinario($row->id,  $username, $patrocinador,$ress);
                      //  $this->VerificarIndicado($patrocinador,$kit);
                    }
                }
            }

        } catch(PDOException $ex) {
            echo "ERRO 01: {$ex->getMessage()}";
        }
    }
    function Binario($id){

        $sel = $this->pdo->query("SELECT * FROM dados_acesso_usuario WHERE (package != '' ) and (package != '0') and NOT EXISTS(SELECT 1 FROM rede_binaria WHERE indicado_id = dados_acesso_usuario.personal_id) and dados_acesso_usuario.personal_id = '$id'");
        $res = $sel->fetchAll(PDO::FETCH_OBJ);
        foreach($res as $row){
            $this->cadastra_binario($row->indicacao_id,$row->personal_id,$row->direcao_cadastro);


        }


    }
    function VerificarIndicado(){


    }
    function AtivarBinario($personal_id,$username,$patrocinador,$ress){
        $ref_perna = $this->PegarPernaPatrocinador($patrocinador);
        $ref_patrocinador = $this->PegarNomePatrocinador($patrocinador);
        $ref_patro_package = $this->BuscarPacote($patrocinador);
        $ref_my_package = $this->BuscarPacote($patrocinador);

        if(isset($ref_perna->personal_id)){
            $patro = $ref_perna->personal_id;
        }else{
            $patro = 0;
        }
        $data = date("Y-m-d");
        $this->pdo->query("INSERT INTO dados_acesso_usuario (personal_id, username, package, point, indication, status, photo,direcao_cadastro,indicacao_id,direcao)
                                                                   VALUES('$personal_id', '$username','$ress->name','$ress->pontos', '$patrocinador','Pendente', 'Personal.png','$ref_perna->perna','$patro','$ref_perna->perna')");

        $this->id = $personal_id;
        $id2 = $ref_patrocinador->id;

        //Selecionando usuario no banco de dados para criar usuário na tabela de acesso.
        $sqlLog = $this->pdo->query("SELECT * FROM dados_acesso_usuario WHERE personal_id = '$personal_id'");
        $untoken = rand(00000,99999);
        $sqlLog = $this->pdo->query("UPDATE usuarios SET token='$untoken' WHERE username='$username' AND id='$personal_id'");

        if($sqlLog->rowCount() >0){

            $this->Binario($personal_id);


        }
    }

    function PegarId($username){

        $sql2 = $this->pdo->query("SELECT id FROM usuarios WHERE username='$username'");
        if($sql2->rowCount()>0){
            $res = $sql2->fetchAll(PDO::FETCH_OBJ);
            foreach($res as $row){
                return $row->id;
            }
        }
    }



    function BuscarPacote($username){
        $sql2 = $this->pdo->query("SELECT * FROM financeiro as f inner join plan as p on f.plan=p.id WHERE f.username='$username'");
        if($sql2->rowCount()>0){
            $res = $sql2->fetchAll(PDO::FETCH_OBJ);
            foreach($res as $row){
                return $row;
            }
        }

    }
// Verificando se usuário já existe no banco de dados.
    function existeUsuario($usuario) {
        try {
// Buscando por usuário passado no parâmetro.
            $stmt = $this->pdo->prepare("SELECT username FROM usuarios WHERE username=:usuario");
            $stmt->bindValue(":usuario", $usuario);
            $stmt->execute();
            if($stmt->rowCount() > 0):
                return true;
            else:
                return false;
            endif;
        } catch(PDOException $ex) {
            echo "ERRO 02: {$ex->getMessage()}";
        }
    }

// Verificando se e-mail já está cadastrado.
    function ExisteEmail($email) {
        try {
            $stmt = $this->pdo->prepare("SELECT email FROM usuarios WHERE email=:email");
            $stmt->bindValue(":email", $email);
            $stmt->execute();
            if($stmt->rowCount() > 500):
                return true;
            else:
                return false;
            endif;
        } catch(PDOException $ex) {
            echo "ERRO 02: {$ex->getMessage()}";
        }
    }

    function StatusBinario($patrocinador){
        try {
            $stmt = $this->pdo->query("SELECT status FROM dados_acesso_usuario WHERE username='$patrocinador' AND status='Ativo'");
            if($stmt->rowCount() > 0):
                return true;
            else:
                return false;
            endif;
        } catch(PDOException $ex) {
            echo "ERRO 02: {$ex->getMessage()}";
        }

    }

    function PegarPernaPatrocinador($patrocinador)
    {
        $stmt = $this->pdo->query("SELECT * FROM dados_acesso_usuario WHERE username='$patrocinador'");
        if ($stmt->rowCount() > 0) {
            $res = $stmt->fetchAll(PDO::FETCH_OBJ);
            foreach ($res as $row) {
                return $row;
            }

        }
    }
// Verificando se patrocinador Existe
    function PegarNomePatrocinador($patrocinador) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE username=:patrocinador");
            $stmt->bindValue(":patrocinador", $patrocinador);
            $stmt->execute();
            if($stmt->rowCount() > 0):
                $res =  $stmt->fetchAll(PDO::FETCH_OBJ);
                foreach($res as $row){
                    return $row ;
                }

            else:
                return false;
            endif;
        } catch(PDOException $ex) {
            echo "ERRO 02: {$ex->getMessage()}";
        }
    }

    function VerificaPatrocinador($patrocinador) {
        try {
            $stmt = $this->pdo->prepare("SELECT username FROM usuarios WHERE username=:patrocinador");
            $stmt->bindValue(":patrocinador", $patrocinador);
            $stmt->execute();
            if($stmt->rowCount() > 0):

                return true;
            else:
                return false;
            endif;
        }catch(PDOException $ex) {
            echo "ERRO 02: {$ex->getMessage()}";
        }
    }
// Verificando se e-mail já está cadastrado.
    function ExisteCpf($cpf) {
        try {
            $stmt = $this->pdo->prepare("SELECT cpf FROM usuarios WHERE cpf=:cpf");
            $stmt->bindValue(":cpf", $cpf);
            $stmt->execute();
            if($stmt->rowCount() > 500):
                return true;
            else:
                return false;
            endif;
        } catch(PDOException $ex) {
            echo "ERRO 02: {$ex->getMessage()}";
        }
    }

    function verificaCpf($cpf){
        $s = $cpf;
        $c = substr($s, 0, 9);
        $dv = substr($s, 9, 2);
        $d1 = 0;
        $v = false;

        for ($i = 0; $i < 9; $i++){
            $d1 = $d1 + substr($c, $i, 1) * (10 - $i);
        }
        if($d1 == 0){
            return false;
        }
        $d1 = 11 - ($d1 % 11);
        if($d1 > 9){
            $d1 = 0;
        }
        if(substr($dv, 0, 1) != $d1){
            return false;
        }
        $d1 = $d1 * 2;
        for ($i = 0; $i < 9; $i++){
            $d1 = $d1 + substr($c, $i, 1) * (11 - $i);
        }
        $d1 = 11 - ($d1 % 11);
        if($d1 > 9){
            $d1 = 0;
        }
        if(substr($dv, 1, 1) != $d1){
            return false;
        }
        if(!$v){
            return true;
        }
    }

    function BuscrId($username){

        $sql = $this->pdo->query("SELECT * FROM usuarios WHERE username='$username' ");
        $res =  $sql->fetchAll(PDO::FETCH_OBJ);
        foreach($res as $row) {
            return $row->id;

        }
    }

    function Sendemail($remetente,$nome,$token,$username){
        require_once("scripts/Classes/class/class.phpmailer.php");
        require_once("scripts/Classes/class/class.smtp.php");


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
            $mail->Username = 'suporte.advantageclub@gmail.com'; // Usuário do servidor SMTP (endereço de email)
            $mail->Password = 'esdp1100'; // Senha do servidor SMTP (senha do email usado)

//Define o remetente
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
            $mail->SetFrom('suporte.advantageclub@gmail.com', 'Clube Advantage'); //Seu e-mail
            $mail->AddReplyTo('suporte.advantageclub@gmail.com', 'Clube Advantage'); //Seu e-mail
            $mail->Subject = 'Ola Sr(a) '. $nome. ' Confime seu cadastro na Clube Advantage';//Assunto do e-mail


//Define os destinatário(s)
//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
            $mail->AddAddress($remetente, 'Confime seu cadastro'); // Configura o email de destino e o Título da mensagem

//Campos abaixo são opcionais
//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//$mail->AddCC('destinarario@dominio.com.br', 'Destinatario'); // Copia
//$mail->AddBCC('destinatario_oculto@dominio.com.br', 'Destinatario2`'); // Cópia Oculta
//$mail->AddAttachment('images/phpmailer.gif');      // Adicionar um anexo


//Define o corpo do email
            $mail->MsgHTML("Clique no link abaixo para confirmar seu cadastro <br> <a href='http://127.0.0.1/2017/Clubeadvantage/confirm.php?username=$username&&token=$token'><button>Validar Minha Conta</button></a>");

////Caso queira colocar o conteudo de um arquivo utilize o método abaixo ao invés da mensagem no corpo do e-mail.
//$mail->MsgHTML(file_get_contents('arquivo.html'));

            $mail->Send();

//caso apresente algum erro é apresentado abaixo com essa exceção.
        }catch (phpmailerException $e) {
            echo $e->errorMessage(); //Mensagem de erro costumizada do PHPMailer
        }

    }

}

?>
