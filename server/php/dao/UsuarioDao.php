<?php
	class UsuarioDao extends AbstractDao {
		
		public function __construct($id = "") {
			parent::__construct("usuario", $id);
		}
		
		public function getPretyObject($id) {
			$usuarioDao = $this->findById($id);
			
			$usuario = new Usuario($usuarioDao->identificador, $usuarioDao->nome, $usuarioDao->senha, $usuarioDao->ativo, $usuarioDao->entidade);
			$usuario->id = $usuarioDao->_id->__toString();
			
			return $usuario;
		}
		
		public function getObjectToSave($usuario) {
			$usuario->senha = md5($usuario->senha);
			return $usuario;
		}
		
		public function inativar($id) {
			$usuario = $this->getPretyObject($id);
			$usuario->ativo = false;
			
			$this->save($usuario);
		}
		
		public function obterUsuarioPorIdentificador($identificador) {
			$usuario = $this->findOne("identificador", $identificador);
			return $this->getPretyObject($usuario->_id->__toString());
		}
		
		public function autenticar($identificador, $senha) {
			$senha = md5($senha);
			
			try {
				$usuario = $this->obterUsuarioPorIdentificador($identificador);
			} catch (InvalidArgumentException $ex) {
				throw new InvalidArgumentException("Usuário ou senha inválidos!");
			}
			
			if ($usuario->senha != $senha) {
				throw new InvalidArgumentException("Usuário ou senha inválidos!");
			}
			
			return $usuario->id;
		}
		
	}
?>