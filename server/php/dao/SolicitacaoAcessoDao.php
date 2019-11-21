<?php
	class SolicitacaoAcessoDao extends AbstractDao {
		
		public $id;
		
		public $idEntidade;
		
		public $identificadorUsuario;
		
		public function __construct($id = "", $idEntidade = "", $identificadorUsuario = "") {
			parent::__construct("solicitacaoAcesso", $id);
			
			if ($idEntidade != "") {
				$usuarioDao = new UsuarioDao($idEntidade);
				
				$this->idEntidade = $usuarioDao->findById($idEntidade)->_id->__toString();
			}
			
			if ($identificadorUsuario != "") {
				$usuarioDao = new UsuarioDao($idEntidade);
				
				$this->identificadorUsuario = $usuarioDao->obterUsuarioPorIdentificador($identificadorUsuario)->identificador;
			}
		}
		
		public function getPretyObject($id) {
			$solicitacaoAcessoDao = $this->findById($id);
			
			$entidadeDao = new UsuarioDao();
			$entidadeDao = $entidadeDao->getPretyObject($solicitacaoAcessoDao->idEntidade->__toString());
			
			$solicitacaoAcesso = new SolicitacaoAcesso($solicitacaoAcessoDao->aceita,$solicitacaoAcessoDao->dadosPessoais);
			$solicitacaoAcesso->id = $solicitacaoAcessoDao->_id->__toString();
			
			$solicitacaoAcesso->identificadorUsuario = $solicitacaoAcessoDao->identificadorUsuario;
			$solicitacaoAcesso->nomeEntidade = $entidadeDao->nome;
			
			return $solicitacaoAcesso;
		}
		
		public function getObjectToSave($solicitacaoAcesso) {
			$usuarioDao = new UsuarioDao();
			
			$solicitacaoAcesso->idEntidade = $usuarioDao->findById($this->idEntidade)->_id;
			$solicitacaoAcesso->identificadorUsuario = $this->identificadorUsuario;
			
			
			return $solicitacaoAcesso;
		}
		
		public function save($solicitacaoAcesso) {
			$usuarioDao = new UsuarioDao();
			$usuario = $usuarioDao->getPretyObject($this->idEntidade);
			
			if (!$usuario->entidade) {
				throw new InvalidArgumentException("Usuário sem permissão para gerar solicitações de acesso!");
			}
			
			$this->validarSolicitacaoAcesso($solicitacaoAcesso);
			
			$this->id = "";
			$solicitacaoAcesso->aceita = false;
			return parent::save($solicitacaoAcesso);
		}
		
		private function validarSolicitacaoAcesso($solicitacaoAcesso) {
			$dadoPessoalDao = new DadoPessoalDao();
			$usuarioDao = new UsuarioDao();
			
			$usuario = $usuarioDao->obterUsuarioPorIdentificador($this->identificadorUsuario);
			
			$dadosPessoaisUsuario = $dadoPessoalDao->obterCamposUsuario($usuario->id);
			
			
			$dadosPessoaisSolicitados = $solicitacaoAcesso->dadosPessoais;
			
			if (empty($solicitacaoAcesso->dadosPessoais)) {
				throw new InvalidArgumentException("Campos solicitados não foram informados!");
			}
			
			foreach ($dadosPessoaisSolicitados as $nomeCampo) {
				$nomeCampo = $nomeCampo->nome;
				
				if (!in_array($nomeCampo, $dadosPessoaisUsuario)) {
					throw new InvalidArgumentException("Usuário ($usuario->identificador) não cadastrou o campo ($nomeCampo)!");
				}
			}
		}
		
		public function obterSolicitacoesUsuario($identificadorUsuario) {
			$solicitacoesUsuario = null;
			$solicitacoes = $this->find("identificadorUsuario", $identificadorUsuario);
			
			foreach ($solicitacoes as $solicitacao) {
				$solicitacoesUsuario []= $this->getPretyObject($solicitacao->_id->__toString());
			}
			
			return $solicitacoesUsuario;
		}
		
		public function obterSolicitacoesEntidade($id) {
			$solicitacoesUsuario = null;
			$solicitacoes = $this->find("idEntidade", $this->getObjectId($id));
			
			foreach ($solicitacoes as $solicitacao) {
				$solicitacoesUsuario []= $this->getPretyObject($solicitacao->_id->__toString());
			}
			
			return $solicitacoesUsuario;
		}
		
		public function obterSolicitacoesAbertasEntidade($id) {
			$solicitacoes = $this->obterSolicitacoesEntidade($id);
			
			foreach ($solicitacoes as $index => $solicitacao) {
				if ($solicitacao->aceita) {
					unset($solicitacoes[$index]);
				}
			}
			
			return $solicitacoes;
		}
		
		public function excluirSolicitacoesUsuario($identificador) {
			$solicitacoesAcessoDao = new SolicitacaoAcessoDao();
			$solicitacoesAcesso = $this->obterSolicitacoesUsuario($identificador);
			
			foreach ($solicitacoesAcesso as $solicitacaoAcesso) {
				$solicitacoesAcessoDao->delete($solicitacaoAcesso->id);
			}
		}
		
		public function excluirSolicitacoesEntidade($idEntidade) {
			$solicitacoesAcessoDao = new SolicitacaoAcessoDao();
			$solicitacoesAcesso = $this->find("idEntidade", $this->getObjectId($idEntidade));
			
			foreach ($solicitacoesAcesso as $solicitacaoAcesso) {
				$solicitacoesAcessoDao->delete($solicitacaoAcesso->_id->__toString());
			}
		}
		
		public function autorizar($identificadorUsuario, $senha, $idSolicitacao) {
			$usuarioDao = new UsuarioDao();
			
			$usuarioDao->autenticar($identificadorUsuario, $senha);
			
			$usuario = $usuarioDao->obterUsuarioPorIdentificador($identificadorUsuario);
			
			$solicitacaoAcesso = $this->getPretyObject($idSolicitacao);
			
			if ($solicitacaoAcesso->identificadorUsuario != $usuario->identificador) {
				throw new InvalidArgumentException("Solicitação não pertence ao usuário ($identificadorUsuario)!");
			}
			
			$solicitacaoAcesso->aceita = true;
			
			return parent::save($solicitacaoAcesso);
		}
		
		public function obterSolicitacoesAutorizadasUsuario($idEntidade) {
			$dadoPessoalDao = new DadoPessoalDao();
			$usuarioDao = new UsuarioDao();
			
			$solicitacoes = $this->obterSolicitacoesEntidade($idEntidade);
			
			$solicitacoesAutorizadas = null;
			
			foreach ($solicitacoes as $solicitacao) {
				if ($solicitacao->aceita) {
					$identificadorUsuario = $solicitacao->identificadorUsuario;
					
					$usuario = $usuarioDao->obterUsuarioPorIdentificador($identificadorUsuario);
					
					$dadosPessoaisUsuario = $dadoPessoalDao->obterDadosPessoaisUsuario($usuario->id);
					
					foreach ($solicitacao->dadosPessoais as $dadoPessoalSolicitacao) {
						foreach ($dadosPessoaisUsuario as $dadoPessoalUsuario) {
							if ($dadoPessoalSolicitacao->nome == $dadoPessoalUsuario->nome) {
								$solicitacoesAutorizadas[$usuario->identificador] []= [$dadoPessoalSolicitacao->nome, $dadoPessoalUsuario->valor];
							}
						}
					}
				}
			}
			return $solicitacoesAutorizadas;
		}
		
	}
?>