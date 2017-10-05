<?php

		
class DB extends DefinesDB{

	public $tabela = null;
	public $where = null;
	public $linhas = -1;
	public $linhas_total = 0;//quando ouver limit: ex em requicoes que havera paginacao
	public $conexao = false;
	public $retorna_query = null;
	public $query = "";
	public $limit = null;
	public $tipo_requisicao = ""; //select,update,delete ou insert
	
	//dados do servidor
	public $host = HOST;
	public $user = USER;
	public $pass = PASS;
	public $db	 = DB;
	
	
	public function __construct($tabela=null){
	
	
	
		$this->conexao = new mysqli($this->host,$this->user,$this->pass,$this->db);
		if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());

		
		if($tabela!=null)
			$this->tabela=$tabela;
		
		
	}
	
	//execultar requisicao de acordo com o parametro passado
	function execulta($tipo){
		$this->tipo_requisicao = $tipo = strtolower($tipo);
		
		if($tipo == 'select' or $tipo == 'SELECT'):$this->select();
			elseif($tipo == 'delete' or $tipo == 'DELETE'):$this->delete();
			elseif($tipo == 'update' or $tipo == 'UPDATE'):$this->update();
			elseif($tipo == 'insert' or $tipo == 'INSERT'):$this->insert();
			else:
			echo "parametro no methodo execulta(parametro) não foi setado ou o paramentro passado não é válido";
			exit;
		endif;
	
	}
	
	
	//methodo para deletar dados do banco
	function delete(){
	
		$sql = "DELETE FROM $this->tabela ";
	
		if($this->where!=null):
			$sql .= " ".$this->where;
		endif;
	
		$this->query = $sql;
		$this->execultaQuery();
	}

	//methodo para selecionar dados do banco
	function select(){
		
		
		$sql = "SELECT ";
		
		if(count($this->from) > 0):
		
			$i = 1;
			foreach($this->from as $key => $value):
			
				if(!empty($value)):
						$sql .= " $key AS $value ";
					else:
						$sql .= " $key ";
				endif;
				
				if(count($this->from) > $i):
					$sql .= ' , ';
				endif;
					
			$i++;
			endforeach;
			
		else:
			$sql .= "* "; 
		endif;
		
		$sql .= "FROM $this->tabela ";
		
		if(count($this->join) > 0):
		

			foreach($this->join as $key => $value):
			
				
						$sql .= " INNER JOIN $key ";
				
			endforeach;
			
		endif;
	
		if($this->where!=null):
			$sql .= " ".$this->where." ";
		endif;

		$this->query = $sql;
		$this->execultaQuery();
		
		
	}
	
	//methodo para atualizar dados no banco
	function update(){
	
		$sql = "";
		$sql .= "UPDATE $this->tabela";
			if(count($this->campos) > 0):
				$sql .= " SET ";
				$i = 1;
				foreach($this->campos as $campo => $valor):
					
					if(!empty($campo)):
					
						$sql .= " $campo = '$valor'";
					endif;
					
					if(count($this->campos) > $i):
						$sql .= ' , ';
					endif;
					
				$i++;	
				endforeach;
			endif;
			
		if($this->where!=null):
			$sql .= " ".$this->where;
		endif;
		
		$this->query = $sql;
		$this->execultaQuery();
	}
	
	//methodo para inserir dados no banco de dados
	function insert(){
	
		$sql = "INSERT INTO $this->tabela ";
			if(count($this->campos) > 0):
				$sql .= " ( ";
				$i = 1;
				foreach($this->campos as $campo => $valor):
					
					if(!empty($campo)):
					
						$sql .= "`$campo`";
					endif;
					
					if(count($this->campos) > $i):
						$sql .= ' , ';
					endif;
					
				$i++;	
				endforeach;
				$sql .= " ) ";
			endif;
			
				$sql .= " VALUES ";
			if(count($this->campos) > 0):
				$sql .= " ( ";
				$i = 1;
				foreach($this->campos as $campo => $valor):
					
					if(!empty($campo)):
					
						$sql .= "'$valor'";
					endif;
					
					if(count($this->campos) > $i):
						$sql .= ' , ';
					endif;
					
				$i++;	
				endforeach;
				$sql .= " ) ";
			endif;
	
	
		$this->query = $sql;
		$this->execultaQuery();
	
	
	}
	
	//execultar requisicoes com o banco
	function execultaQuery(){

		if($this->limit!=null and $this->tipo_requisicao == 'select'):
			
			
				mysqli_query($this->conexao,$this->query)or die(mysqli_error());
				
					$this->linhas_total =$this->conexao->affected_rows;
				
					if(empty($this->where)):
						$this->query .= " where 1=1 ";
					endif;
					
					$this->query .= " ".$this->limit." ";
					
					$this->query = mysqli_query($this->conexao,$this->query)or die(mysqli_error());
				
					$this->linhas =$this->conexao->affected_rows;
				
				else:
				echo $this->conexao;
				echo $this->query;
					$this->query = $this->conexao($this->query)or die(mysqli_error());
				
					$this->linhas =$this->conexao->affected_rows;
					$this->linhas_total =$this->conexao->affected_rows;
				
		endif;
	
		if($this->conexao!=false):
			$this->conexao=false;
		endif;
	}
	
	
	//usar query diretas sem usar methodos e paramentos ex: $variavel->Query("SELECT * FROM tabela WHERE campo = valor and limit 100");
	function Query($query){
		
		$this->query = $query;
		$this->execultaQuery();
		
	}
	
	function retorno($tipo='array'){
	
	
	
		switch ($tipo):
			case "array":
			
				return mysqli_fetch_array($this->query);
				
			break;
		
			case "object":
				return mysqli_fetch_object($this->query);
			break;
			case "assoc":
				return mysqli_fetch_assoc($this->query);
			break;
			
		endswitch;
		
	
	
	}
	
}

?>