<?php

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
require_once("../scripts/Classes/connection/connect.php");
class Login {
    private $pdo;

// Função que faz a construção da classe de conexão com o banco de dados.
    function __construct() {
        $this->con = new Connection;
        $this->pdo = $this->con->Connect();
    }


    function
    Logar($username,$password){
        $sql = $this->pdo->prepare("SELECT username,password FROM admin WHERE username=:username AND password=:password");
        $stmt = array(
            ":username" =>$username,
            ":password" => $password,
        );
        $sql->execute($stmt);
        if($sql->rowCount()>0){

            return true;

        }else{
            return false;

        }
    }


}