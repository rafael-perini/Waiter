<?php
	class UsuariosWebService {
		
		/**
		* Salvar
		*
		* @param string id
		* @param string identificador
		* @param string nome
		* @param string senha
		* @result string
		*/
		public function salvar($id, $identificador, $nome, $senha) {
			$usuario = new Usuario($identificador, $nome, $senha);
			$usuarioDao = new UsuarioDao($id);
			
			return (array) $usuarioDao->save($usuario);
		}
		
		/**
		* Excluir
		*
		* @param string $id
		* @result boolean
		*/
		public function excluir($id) {
			$usuarioDao = new UsuarioDao();
			$dadoPessoalDao = new DadoPessoalDao();
			$solicitacaoAcessoDao = new SolicitacaoAcessoDao();
			
			$usuario = $usuarioDao->getPretyObject($id);
			
			$usuarioDao->delete($id);
			
			try {
				$dadoPessoalDao->excluirCamposUsuario($id);
			} catch (InvalidArgumentException $ex) {
				echo $ex;
			}
			
			try {
				$solicitacaoAcessoDao->excluirSolicitacoesUsuario($usuario->identificador);
			} catch (InvalidArgumentException $ex) {
				echo $ex;
			}
			
			try {
				$solicitacaoAcessoDao->excluirSolicitacoesEntidade($usuario->id);
			} catch (InvalidArgumentException $ex) {
				echo $ex;
			}
			
			return true;
		}
		
		/**
		* Autenticar
		*
		* @param $identificador
		* @param $senha
		* @result boolean
		*/
		public function autenticar($identificador, $senha) {
			$usuarioDao = new UsuarioDao();
			
			return $usuarioDao->autenticar($identificador, $senha);
		}
		
	}
?>