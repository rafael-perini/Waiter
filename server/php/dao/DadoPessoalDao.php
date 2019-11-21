<?php
	class DadoPessoalDao extends AbstractDao {
		
		public $idUsuario;
		
		public function __construct($id = "", $idUsuario = "") {
			parent::__construct("dadoPessoal", $id);
			
			if ($idUsuario != "") {
				$usuarioDao = new UsuarioDao($idUsuario);
				
				$this->idUsuario = $usuarioDao->findById($idUsuario)->_id->__toString();
			}
		}
		
		public function getPretyObject($id) {
			$dadoPessoalDao = $this->findById($id);
			
			$dadoPessoal = new DadoPessoal($dadoPessoalDao->nome, $dadoPessoalDao->valor);
			
			$dadoPessoal->id = $dadoPessoalDao->_id->__toString();
			$dadoPessoal->idUsuario = $dadoPessoalDao->idUsuario->__toString();
			
			return $dadoPessoal;
		}
		
		public function getObjectToSave($dadoPessoal) {
			$usuarioDao = new UsuarioDao();
			$dadoPessoal->idUsuario = $usuarioDao->findById($this->idUsuario)->_id;
			
			return $dadoPessoal;
		}
		
		public function obterCamposUsuario($idUsuario) {
			$dadoPessoalDao = new DadoPessoalDao();
			$dadosPessoais = $dadoPessoalDao->obterDadosPessoaisUsuario($idUsuario);
			
			if (!is_null($dadosPessoais)) {
				foreach ($dadosPessoais as $index => $dadoPessoal) {
					$dadosPessoais[$index] = $dadoPessoal->nome;
				}
			}
			
			return $dadosPessoais;
		}
		
		public function obterDadosPessoaisUsuario($idUsuario) {
			$idUsuario = $this->getObjectId($idUsuario);
			
			try {
				$dadosPessoais = $this->find("idUsuario", $idUsuario);
			} catch (InvalidArgumentException $ex) {
				throw new InvalidArgumentException("Dados pessoais do usuário com id $idUsuario não foram encontrados!");
			}
			
			if (is_null($dadosPessoais)) {
				throw new InvalidArgumentException("Dados pessoais do usuário com id $idUsuario não foram encontrados!");
			}
			
			$result = null;
			
			foreach ($dadosPessoais as $dadoPessoal) {
				$dadoPessoal = $this->getPretyObject($dadoPessoal->_id->__toString());
				$result []= $dadoPessoal;
			}
			
			return $result;
			}
		
		public function excluirCamposUsuario($idUsuario) {
			$dadosPessoais = $this->obterDadosPessoaisUsuario($idUsuario);
			
			if (!is_null($dadosPessoais)) {
				foreach ($dadosPessoais as $dadoPessoal) {
					$this->delete($dadoPessoal->id);
				}
			}
			
			return true;
		}
		
	}
?>