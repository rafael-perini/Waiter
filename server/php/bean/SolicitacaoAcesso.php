<?php
	class SolicitacaoAcesso extends AbstractBean {
		
		public $aceita;
		
		public $dadosPessoais;
		
		public function __construct($aceita = false, $dadosPessoais = []) {
			$this->aceita = $aceita;
			$this->dadosPessoais = $dadosPessoais;
		}
		
	}
?>