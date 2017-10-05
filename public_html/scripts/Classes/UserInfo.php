<?php
/**
 * Created by PhpStorm.
 * User: elifas
 * Date: 03/11/16
 * Time: 04:17
 */
// Chamando Classe que faz a conexão com o banco de dados.
require_once("connection/connect.php");
class UserInfo {

    private $pdo;

    // Função que faz a construção da classe de conexão com o banco de dados.
    function __construct() {
        $this->con = new Connection;
        $this->pdo = $this->con->Connect();
    }


    function ContarIndiretos($indireto){
        $sql = $this->pdo->query("SELECT COUNT(username)as total_indiretos FROM usuarios WHERE patrocinador='$indireto' ");
        $res = $sql->fetchAll(PDO::FETCH_OBJ);
        foreach($res as $row){
            return $row->total_indiretos;
        }


    }

    function BuscarOnline(){

        $sql = $this->pdo->query("SELECT SUM(username)as total_online FROM usuarios WHERE chat_status='Online' ");
        $res = $sql->fetchAll(PDO::FETCH_OBJ);
        foreach($res as $row){
            return $row;
        }


    }

    function BuscarAll(){

        $sql = $this->pdo->query("SELECT SUM(username)as total_usuarios FROM usuarios ");
        $res = $sql->fetchAll(PDO::FETCH_OBJ);
        foreach($res as $row){
            return $row;
        }

    }

    function BuscarTudo($userLog){

        $sql = $this->pdo->query("SELECT * FROM usuarios as u INNER JOIN financeiro as f on u.id=f.personal_id WHERE u.username='$userLog'");
        if($sql->rowCount()>0){
            $res = $sql->fetchAll(PDO::FETCH_OBJ);
            foreach($res as $row){
                return $row;
            }
        }


    }

    function BuscarTudo2($userLog){

        $sql = $this->pdo->query("SELECT * FROM dados_acesso_usuario WHERE username='$userLog'");
        if($sql->rowCount()>0){
            $res = $sql->fetchAll(PDO::FETCH_OBJ);
            foreach($res as $row){
                return $row;
            }
        }


    }

    function BuscarIndiretos($userLog){

        $sql = $this->pdo->query("SELECT * FROM usuarios as u INNER JOIN financeiro as f ON u.id=f.personal_id WHERE u.username='$userLog'");
        if($sql->rowCount()>0){
            $res = $sql->fetchAll(PDO::FETCH_OBJ);
            foreach($res as $row ){
                return $row;
            }

        }
    }

    function BuscarAdmin(){

        $sql = $this->pdo->query("SELECT * FROM admin");
        if($sql->rowCount()>0){
            $res = $sql->fetchAll(PDO::FETCH_OBJ);
            foreach($res as $row){
                return $row;
            }
        }


    }

    function BuscarPlan($plan){

        $sql = $this->pdo->query("SELECT * FROM plan where id='$plan'");
        if($sql->rowCount()>0){
            $res = $sql->fetchAll(PDO::FETCH_OBJ);
            foreach($res as $row){
                return $row;
            }
        }


    }

    function BuscarPlan_valor($plan){

        $sql = $this->pdo->query("SELECT * FROM plan where price_btc='$plan'");
        if($sql->rowCount()>0){
            $res = $sql->fetchAll(PDO::FETCH_OBJ);
            foreach($res as $row){
                return $row->name;
            }
        }


    }

    function ContarInvoice($personal_id){

        $sql = $this->pdo->query("SELECT COUNT(pedido) as c_invoice FROM invoice_upgrade where personal_id='$personal_id'");
        if($sql->rowCount()>0){
            $res = $sql->fetch(PDO::FETCH_OBJ);
            return $res->c_invoice;

        }else{
            return 0;
        }
    }

    function ContarIndicados($username){

        $sql = $this->pdo->query("SELECT COUNT(username) as C_patrocinador FROM usuarios where patrocinador='$username'");
        if($sql->rowCount()>0){
            $res = $sql->fetch(PDO::FETCH_OBJ);
            return $res->C_patrocinador;

        }else{
            return 0;
        }
    }

    function BuscarWhitdraw($username,$dia_hoje){

        $sql =$this->pdo->query("SELECT SUM(valor) as subvalor,count(username) as rowcont FROM withdraw WHERE username='$username' AND data LIKE '%$dia_hoje%' ");
        $res = $sql->fetch(PDO::FETCH_OBJ);
        return   $res->rowcont;



    }

    function BuscarWhitdraw_date($username,$data){

        $sql =$this->pdo->query("SELECT * FROM withdraw WHERE username='$username' AND data LIKE '%$data%'  ");

        return $sql->rowCount();


    }


    function BuscarRenovacao($username){

        $sql = $this->pdo->query("SELECT * FROM renovacao WHERE username='$username'");
        if($sql->rowCount()>0){
            $res = $sql->fetchAll(PDO::FETCH_OBJ);
            foreach($res as $row){
                return $row;
            }
        }

    }



}
