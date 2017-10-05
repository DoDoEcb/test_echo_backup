<?php

@mysql_connect('mysql.hostinger.com.br','u419341421_empir','Picote1100@@');
@mysql_select_db('u419341421_empir');
mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');


Class Banco extends DefinesDB {

    public $tabela = null;
    public $where = null;
    public $linhas = -1;
    public $linhas_total = 0;//quando ouver limit: ex em requicoes que havera paginacao
    public $row = -1;
    public $conexao = false;
    public $retorna_query = null;
    public $query = "";
    public $limit = null;
    public $tipo_requisicao = ""; //select,update,delete ou insert
    public $id = null;
    public $comdExec = "";


    //execultar requisicoes com o banco

    public function __construct($tabela=null){

    }

    function execultaQuery(){
        $this->comdExec = $this->query;
        $query = $this->query;

        $this->query = mysql_query($this->query)or die(mysql_error());
        if($this->bTem("select ",$query) == true){
            $this->linhas_total = mysql_num_rows($this->query);
            $this->row =$this->linhas_total;
        }

        if($this->bTem("insert ",$query) == true){
            $this->id = mysql_insert_id();
        }


    }

    function bTem ($palavra,$frase){
        if(count(explode(strtoupper($palavra),strtoupper($frase))) > 1){
            return true;
        }
        return false;
    }
    //usar query diretas sem usar methodos e paramentos ex: $variavel->Query("SELECT * FROM tabela WHERE campo = valor and limit 100");
    function Query($query){

        $this->query = $query;
        $this->execultaQuery();

    }


    function retorno($tipo='object'){

        switch ($tipo):
            case "array":

                return mysql_fetch_array($this->query);

                break;

            case "object":
                return mysql_fetch_object($this->query);
                break;
            case "assoc":
                return mysql_fetch_assoc($this->query);
                break;

        endswitch;



    }

}

?>
