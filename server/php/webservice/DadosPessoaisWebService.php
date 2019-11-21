<?php
	class DadosPessoaisWebService {
		
		/**
		* Salvar
		*
		* @param string $id
		* @param string $nome
		* @param string $valor
		* @param string $idUsuario
		* @return string
		*/
		function salvar($id, $nome, $valor, $idUsuario) {
			$dadoPessoal = new DadoPessoal($nome, $valor);
			$dadoPessoalDao = new DadoPessoalDao($id, $idUsuario);
			
			return (array) $dadoPessoalDao->save($dadoPessoal);
		}
		
		/**
		* Excluir
		*
		* @param string $id
		* @param string $idUsuario
		* @result boolean
		*/
		function excluir($id, $idUsuario) {
			$dadoPessoalDao = new DadoPessoalDao($id, $idUsuario);
			
			return $dadoPessoalDao->delete($id);
		}
		
		/**
		* Obter
		*
		* @param string $id
		* @param string $idUsuario
		* @result string
		*/
		function obter($id, $idUsuario) {
			$dadoPessoalDao = new DadoPessoalDao($id, $idUsuario);
			
			return (array) $dadoPessoalDao->getPretyObject($id);
		}
		
		/**
		* Obter Campos
		*
		* @param string $idUsuario
		* @result string
		*/
		function obterCampos($idUsuario) {
			$dadoPessoalDao = new DadoPessoalDao();
			
			return $dadoPessoalDao->obterCamposUsuario($idUsuario);
		}
		
		/**
		* Obter Campos Usuário
		*
		* @param string $identificadorUsuario
		* @param string $senha
		* @result string
		*/
		function obterCamposUsuario($identificadorUsuario, $senha) {
			$dadoPessoalDao = new DadoPessoalDao();
			$usuarioDao = new UsuarioDao();
			
			$usuarioDao->autenticar($identificadorUsuario, $senha);
			
			$usuario = $usuarioDao->obterUsuarioPorIdentificador($identificadorUsuario);
			
			return $dadoPessoalDao->obterDadosPessoaisUsuario($usuario->id);
		}
		
	}
?>