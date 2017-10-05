<?php 
error_reporting(E_ALL);
Class Boleto extends Banco{
	
	var $dias_de_prazo_para_pagamento = 3;
	var $data_venc = '';
	var $valor_cobrado = '';
	var $nosso_numero = '';
	var $numero_documento = '';
	var $data_documento = '';
	var $valor_boleto = '';
	var $personal_id='';
	var $pedido_id='';
	var $total = 0;
	var $subInfo = array();
	var $sep = '-';
	
	var $sacado = '';//"Robson Gomes de Jesus";
	var $endereco1 = '';//"Rua dos Eucaliptos 483";
	var $endereco2 = '';//"Serra - ES -  CEP: 29172-140";
	var $demonstrativo1 = '';//"Pagamento de Adesao";
	
	var $codigo_boleto = '';
	var $id_boleto = '';
	var $codigo_de_barra;
	
	var $dadosPedido = array();
	var $tipo = array();
	
function exibeBoleto_($numero){
}
	function exibeBoleto($codigo){
		
		
		
		if(isset($_GET['cria'])){$codigo .='-1';}
		if(isset($_GET['exibe']) and empty($_GET['exibe'])){return false;}
		
		
		
		$this->codigo_boleto = $codigo;
		$this->numero_documento = $codigo;
		$numero = explode($this->sep,$codigo);
		$n_doc = '';
		for($i=0;$i<count($numero)-1;$i++){
			$n_doc .= $numero[$i];
		}
		
		$pedido = explode('.',$n_doc);
		if(count($pedido)){}
		$personal_id = $pedido[0];
		if(count($pedido)<2){ $pedido[1] = 9999;} //anti mensagem de erro
		$this->pedido_id = $pedido_id = $pedido[1];
		
		
		$n = ($numero[count($numero)-1]-1);
		
		
		
		if(isset($_GET['exibe']) and !isset($_GET['cria'])){
			if(empty($_GET['exibe'])){return false;}
			if(!is_numeric(str_replace('-','',str_replace('.','',$_GET['exibe'])))){return false;}
			if($this->dadosPedido() == false){
				return false;
			}
		}
		
		
		
		if(isset($_GET['cria'])){ $this->criaBoleto($personal_id,$pedido_id);}
		if($this->id != null){
			$where = "id_boleto = '$this->id'";
		}else{
			$where = "numero_documento = '$n_doc' limit $n,1";
		}
		
		$this->Query("SELECT * FROM boleto  LEFT JOIN pedidos ON pedidos.id = '$pedido_id'
								 LEFT JOIN  dados_pessoais_usuario ON dados_pessoais_usuario.id = '$personal_id' WHERE 1=1 and $where");
		if($this->row < 1){ return false;}
		
		$retorno = $this->retorno();
		$this->data_venc = $retorno->vencimento;
		$this->valor_cobrado = number_format($retorno->valor, 2, ',', '');
		$this->data_documento = $retorno->data;
		$this->nosso_numero = $pedido_id;
		$this->sacado = $retorno->nome;
		$this->endereco1 = $retorno->adress ." " . $retorno->numb;//"Rua dos Eucaliptos 483";
		$this->endereco2 = $retorno->neighborhood . ", " .$retorno->city.' - ' . $retorno->state . ' - CEP: '.$retorno->cep;//"Serra - ES -  CEP: 29172-140";
		$this->demonstrativo1 = $retorno->descricao.' '.$retorno->pacotedes. ' n° '.$retorno->ides;//"Pagamento de Adesao";
		$this->id_boleto = $retorno->id_boleto;
		$this->codigo_de_barra = $retorno->codigo_de_barra;
	}
	function __construct(){
		$this->data_venc = date("d/m/Y", time() + ($this->dias_de_prazo_para_pagamento * 86400));
		$this->data_documento = date("d/m/Y");
		$this->data_processamento = date("d/m/Y");
		
		$this->tipoBoleto['Adesao'] = 'adesao';
		$this->tipoBoleto['Adesão'] = 'adesao';
	}
	function criaBoleto($personal_id,$pedido_id){
		$this->pedido_id = $pedido_id;
		
		if($this->dadosPedido() == false){
			return false;
		}
		$tipo = $this->tipoBoleto[$this->dadosPedido['descricao']];
		
		
		$this->Query("UPDATE boleto set situacao = 'cancelado' WHERE personal_id = '$personal_id' and pedido_id = '$pedido_id' and situacao = 'gerado'");
		$this->Query("INSERT INTO boleto 
					(personal_id,pedido_id,nosso_numero,numero_documento,tipo_boleto,situacao,responsavel,data,vencimento) VALUES 
					('$personal_id','$pedido_id','$pedido_id','$personal_id.$pedido_id','$tipo','gerado','sistema','$this->data_documento','$this->data_venc')");
		return true;
	}
	function geraBoleto($personal_id,$pedido_id){
		
		$this->personal_id = $personal_id;
		$this->pedido_id = $pedido_id;
		
		$this->Query("SELECT * FROM dados_acesso_usuario LEFT JOIN pedidos ON pedidos.id = '$pedido_id' WHERE dados_acesso_usuario.personal_id = '$personal_id'");
		if($this->row < 1){ return false;}
		
		$retorno = $this->retorno();
		$this->numero_documento = $this->getDados();
		
	}
	function dadosPedido(){
		
		$this->Query("SELECT descricao,ides,pacotedes,valor,personal_id FROM pedidos WHERE id = '$this->pedido_id' and pg = '0'");
		if($this->row < 1){ return false;}
		$this->dadosPedido = $this->retorno('array');
		
		return true;
		
	}
	function getDados(){
		
		$this->Query("SELECT * FROM boleto WHERE numero_documento like '$this->personal_id.$this->pedido_id%'");
		if($this->row < 1){ return false;}
		$this->total;
		$ret = "";
		$i = 0;
		while($retorno = $this->retorno()){
			foreach($retorno as $k => $v){
				$this->subInfo[$i][$k] = $v;
				if($k == 'situacao' and $v == 'gerado'){
					$ret = $this->personal_id.".".$this->pedido_id.$this->sep.$this->row;
				}
			}
			$i++;
		}
		return $ret;
	}
	
	
	function atualizaCodigoDeBarra($codigo){
		
		$this->Query("Update boleto set codigo_de_barra = '$codigo' WHERE id_boleto = '$this->id_boleto'");
	}
	
	function contaPedidos($pedido_id){
		$this->Query("SELECT * FROM boleto WHERE pedido_id = '$pedido_id'");
		return $this->row;
	}
}
?>