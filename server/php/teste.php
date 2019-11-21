<?php
	require_once __DIR__ . "/vendor/autoload.php";
	require_once __DIR__ . "/autoload.php";
	
	$idEntidade = "5b67a8bad8a5d722600041dd";
	$idUsuario = "5b67748bd8a5d722600041d5";
	$idSolicitacao = "5b6e5ee4d8a5d71990007d8d";
	$identificador = "tester";
	$senha = 123;
	$nome = "TESTE";
	$valor = "ABC";
	
	$dadosPessoais = [];
	
	$dao = new SolicitacaoAcessoDao();

	var_dump((array) $dao->autorizar($identificador, $senha, $idSolicitacao));
?>