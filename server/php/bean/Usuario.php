<?php
	class Usuario extends AbstractBean {
		
		public $identificador;
		
		public $nome;
		
		public $senha;
		
		public $ativo;
		
		public $entidade;
		
		public function __construct($identificador = "", $nome = "", $senha = "", $ativo = true, $entidade = false) {
			$this->identificador = $identificador;
			$this->nome = $nome;
			$this->senha = $senha;
			$this->ativo = $ativo;
			$this->entidade = $entidade;
		}
		
	}
?>