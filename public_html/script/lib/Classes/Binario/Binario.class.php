<?php
/**
 * Created by PhpStorm.
 * User: elifas
 * Date: 04/12/16
 * Time: 18:58
 */
require_once("connection/connect.php");
class Binario
{
    private $pdo;

    var $dependencias = false;
    var $pernaEsquerda = "";
    var $pernaDireita = "";
    var $equiparados = "";
    var $pontos = 0;
    var $planoDeCarreira = 0;
    var $personal_id = "";


    function __construct($personal_id = 0)
    {

        $this->con = new Connection;
        $this->pdo = $this->con->Connect();
        $pacote = $this->pdo->query("SELECT plan,username FROM financeiro WHERE personal_id = '$personal_id'");
        if ($pacote->rowCount() <= 0) {
            return false;
        }
        $res = $pacote->fetch(PDO::FETCH_OBJ);

        $this->pontosPacote($res->plan);
        $soma = $this->soma($personal_id);
        $this->equiparados = $soma;
        $this->planoDeCarreira = $soma;


    }



    function pontosPacote($package){
        $package = $this->pdo->query("SELECT * FROM plan WHERE id = '$package'");
        if($package->rowCount() < 1){return false;}
        $res = $package->fetch(PDO::FETCH_OBJ);
        $this->pontos = $res->pontos;
    }

    function pegaChaveDentro($chave)
    {

        $chave = explode(',', $chave);
        $nchave = "";
        foreach ($chave as $k => $v) {
            if (is_numeric($v) and $v > 0) {
                $nchave .= $v . ",";
            }

        }
        $nchave .= "10";

        $chave = $nchave;

        $rede = $this->pdo->query("SELECT personal_id FROM `dados_acesso_usuario` WHERE indicacao_id IN ($chave)");
        if ($rede->rowCount() <= 0) {
            return $chave;
        }
        $chave = "";

        while ($res = $rede->fetch(PDO::FETCH_OBJ)) {
            $chave .= $res->personal_id.",";
        }

        return trim($chave.$this->pegaChaveDentro($chave),",");
    }
    function somas($personal_id){
        $soma = $this->pdo->query("SELECT SUM(bonus) as valor FROM binarios_bonificados WHERE personal_id = '$personal_id'");
        if($soma->rowCount() <= 0){
            return 0;
        }
        $res = $soma->fetch(PDO::FETCH_OBJ);
        return $res->valor;
    }
    function somaEsquerda($personal_id){
        $soma = $this->pdo->query("SELECT SUM(equiparado) as valor FROM binarios_bonificados WHERE personal_id = '$personal_id' AND perna_menor='esquerda' ");
        if($soma->rowCount() <= 0){
            return 0;
        }
        $res = $soma->fetch(PDO::FETCH_OBJ);
        return $res->valor;
    }
    function soma($personal_id){
        $soma = $this->pdo->query("SELECT SUM(equiparado) as valor FROM binarios_bonificados WHERE personal_id = '$personal_id' ");
        if($soma->rowCount() <= 0){
            return 0;
        }
        $res = $soma->fetch(PDO::FETCH_OBJ);
        return $res->valor;
    }

    function somaDireita($personal_id){
        $soma = $this->pdo->query("SELECT SUM(equiparado) as valor FROM binarios_bonificados WHERE personal_id = '$personal_id' AND perna_menor='direita' ");
        if($soma->rowCount() <= 0){
            return 0;
        }
        $res = $soma->fetch(PDO::FETCH_OBJ);
        return $res->valor;
    }

    function somaPernas($personal_id,$perna){
        $soma = $this->pdo->query("SELECT SUM(bonus) as valor FROM binarios_bonificados WHERE personal_id = '$personal_id' AND perna_menor='$perna'");
        if($soma->rowCount() <= 0){
            return 0;
        }
        $res = $soma->fetch(PDO::FETCH_OBJ);
        return $res->valor;
    }

    function PegarPernaEsquerda($personal_id){

        $esquerda = $this->pdo->query("SELECT indicado_id FROM rede_binaria WHERE personal_id IN ($personal_id) and log_perna = 'esquerda'");
        if($esquerda->rowCount() <= 0){
            return "0";
        }else{
            $res = $esquerda->fetch(PDO::FETCH_OBJ);
            return $res->indicado_id.",".$this->PegarPernaEsquerda($res->indicado_id);
        }
    }



    function PegarTodos($personal_id){

        $sql = $this->pdo->query("SELECT indicado_id FROM rede_binaria WHERE personal_id IN ($personal_id)");
        if($sql->rowCount()>0){
            $res = $sql->fetchAll(PDO::FETCH_OBJ);
            foreach($res as $row) {
                return $row->indicado_id.",".$this->pegarDownliness($row->indicado_id);
            }
        }


    }


    function PegarPernaDireta($personal_id){
        $esquerda = $this->pdo->query("SELECT indicado_id FROM rede_binaria WHERE personal_id IN ($personal_id) and log_perna = 'direita'");
        if($esquerda->rowCount() <= 0){
            return "0";
        }else{
            $res = $esquerda->fetch(PDO::FETCH_OBJ);
            return $res->indicado_id.",".$this->PegarPernaDireta($res->indicado_id);
        }
    }

    function PegarPernas($personal_id){
        $esquerda = $this->pdo->query("SELECT indicado_id FROM rede_binaria WHERE personal_id IN ($personal_id)");
        if($esquerda->rowCount() <= 0){
            return "0";
        }else{
            $res = $esquerda->fetch(PDO::FETCH_OBJ);
            return $res->indicado_id.",".$this->PegarPernaDireta($res->indicado_id);
        }
    }

    function ContarUsuariosEsquerda($personal_id){
        $esquerda = $this->pdo->query("SELECT SUM(username) FROM rede_binaria WHERE personal_id='$personal_id' and log_perna = 'esquerda'");
        if($esquerda->rowCount() <= 0){
            return "0,";
        }else{
            $res = $esquerda->fetch(PDO::FETCH_OBJ);
            return $res->indicado_id.",".$this->PegarPernaEsquerda($res->indicado_id);
        }
    }




    function pegarTodosDownlinesDireita($personal_id)
    {
        $chave_dir = $this->PegarPernaDireta($personal_id);

        return  $chave = $chave_dir;





    }
    function pegarTodosDownlinesEsquerda($personal_id)
    {
        $chave_dir = $this->PegarPernaEsquerda($personal_id);

        return  $chave = $chave_dir;





    }

    function pegarDownliness($personal_id)
    {


    }


    function SomarPontos($personal_id){
        $esquerda = $this->pdo->query("SELECT SUM(p.pontos) as pontos FROM financeiro as f INNER JOIN plan as p on f.plan=p.id WHERE f.personal_id IN ($personal_id) AND f.status='Ativo'  ");
        if($esquerda->rowCount()>0) {
            $res = $esquerda->fetch(PDO::FETCH_OBJ);
            return $res->pontos;
        }
    }
    function SomarPontosPerna($username,$perna,$data){
        $esquerda = $this->pdo->query("SELECT SUM(p.pontos) as pontos FROM financeiro as f INNER JOIN plan as p INNER JOIN dados_acesso_usuario as d ON (f.plan=p.id AND d.personal_id=f.personal_id) WHERE d.personal_id IN ($username) AND d.data='$data' AND d.perna='$perna' ");
        if($esquerda->rowCount()>0) {
            $res = $esquerda->fetch(PDO::FETCH_OBJ);
            return $res->pontos;

        }
    }

    function bonifica($personal_id,$bonus,$limite,$chave_esquerda,$chave_direita,$perna,$username,$bonus_esquerda,$bonus_direita,$binario,$qualificado){
        $qe = $bonus;
        $bonus = $bonus*$binario/100;
        if($bonus <=0){
            $bonus = 0;
        }
        if($bonus > 0) {
            if($bonus <= $limite){
                $bonus = $bonus;
                echo " <br>O Usuário : $username Recebeu um Total de $bonus Pontos de sua Perna Menor <br>";

            }elseif( $bonus >= $limite){
                $bonus = $limite;
                echo " <br>O Usuário : $username Recebeu um recebeu o teto maximo de $limite <br>";
            }


            $data = date("Y-m-d");
            $pedido = rand(000000, 999999);
            $this->pdo->query("INSERT INTO binarios_bonificados (personal_id,bonus,valor_esquerda,valor_direita,chave_direita,chave_esquerda,perna_menor,data,equiparado) VALUES ('$personal_id','$bonus','$bonus_esquerda','$bonus_direita','$chave_direita','$chave_esquerda','$perna','$data','$qe') ");

            $this->pdo->query("INSERT INTO extrato (data, username, descricao, pedido_id,personal_id,status,valor )VALUES('$data','$username','Bônus Binário de $binario% Perna Menor','$pedido','$personal_id','Payd','$bonus')");

            if ($qualificado == 'Qualificado') {
                $this->pdo->query("UPDATE financeiro SET saldo=saldo + '$bonus',renovar_saldo=renovar_saldo+'$bonus' where personal_id = '$personal_id' AND status='Ativo'");
                if ($perna == 'esquerda') {
                    $this->pdo->query("INSERT INTO binarios_bonificados (personal_id,bonus,valor_esquerda,valor_direita,chave_direita,chave_esquerda,perna_menor,data,equiparado) VALUES ('$personal_id','$bonus','0','0','0','0','direita','$data','$qe') ");
                } else {
                    $this->pdo->query("INSERT INTO binarios_bonificados (personal_id,bonus,valor_esquerda,valor_direita,chave_direita,chave_esquerda,perna_menor,data,equiparado) VALUES ('$personal_id','$bonus','0','0','0','0','esquerda','$data','$qe') ");

                }
            }

        }

    }


    function removeFalhas($chave){
        $chave = explode(',',$chave);
        $nchave = "";
        foreach($chave as $k => $v){
            if(is_numeric($v) and $v > 0){
                $nchave .= $v.",";
            }

        }
        $chave = $nchave."0";
        return $chave;
    }



}