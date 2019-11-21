<?php
	class SolicitacaoAcessoWebService {
		
		/**
		* Salvar
		*
		* @param string $idEntidade
		* @param string $identificadorUsuario
		* @param string $dadosPessoais
		* @return string
		*/
		function salvar($idEntidade, $identificadorUsuario, $dadosPessoais) {
			$dadosPessoais = json_decode($dadosPessoais);
			
			$solicitacaoAcesso = new SolicitacaoAcesso("", $dadosPessoais);
			$solicitacaoAcessoDao = new SolicitacaoAcessoDao("", $idEntidade, $identificadorUsuario);
			
			return (array) $solicitacaoAcessoDao->save($solicitacaoAcesso);
		}
		
		/**
		* Excluir
		*
		* @param string $id
		* @result boolean
		*/
		function excluir($id) {
			$solicitacaoAcessoDao = new SolicitacaoAcessoDao($id);
			
			return $solicitacaoAcessoDao->delete($id);
		}
		
		/**
		* Obter Solicitações de Acesso da Entidade
		*
		* @param string $id
		* @result string
		*/
		function obterSolicitacoesAbertasEntidade($id) {
			$solicitacaoAcessoDao = new SolicitacaoAcessoDao($id);
			
			return (array) $solicitacaoAcessoDao->obterSolicitacoesAbertasEntidade($id);
		}
		
		/**
		* Obter Solicitações de Acesso para o Usuário
		*
		* @param string $identificadorUsuario
		* @result string
		*/
		function obterSolicitacoesUsuario($identificadorUsuario) {
			$solicitacaoAcessoDao = new SolicitacaoAcessoDao();
			
			return (array) $solicitacaoAcessoDao->obterSolicitacoesUsuario($identificadorUsuario);
		}
		
		/**
		* Autorizar Solicitação
		*
		* @param string $identificadorUsuario
		* @param string $senha
		* @param string $idSolicitacao
		* $result string
		*/
		function autorizar($identificadorUsuario, $senha, $idSolicitacao) {
			$solicitacaoAcesso = new SolicitacaoAcessoDao();
			$solicitacaoAcesso = $solicitacaoAcesso->findById($idSolicitacao);
			
			$solicitacaoAcessoDao = new SolicitacaoAcessoDao($idSolicitacao, $solicitacaoAcesso->idEntidade, $solicitacaoAcesso->identificadorUsuario);
			
			return (array) $solicitacaoAcessoDao->autorizar($identificadorUsuario, $senha, $idSolicitacao);
		}
		
		/**
		* Obter Solicitações Autorizadas
		*
		* @param string $idEntidade
		* @result string
		*/
		function obterSolicitacoesAutorizadasUsuario($idEntidade) {
			$solicitacaoAcessoDao = new SolicitacaoAcessoDao();
			
			return $solicitacaoAcessoDao->obterSolicitacoesAutorizadasUsuario($idEntidade);
		}
		
	}
?>