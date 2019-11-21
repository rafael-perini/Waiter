<?php
	require_once __DIR__ . "/webServiceAutoload.php";
	require_once __DIR__ . "/webservice/SolicitacaoAcessoWebService.php";
	
	$server = new Zend_Rest_Server();
	$server->setClass('SolicitacaoAcessoWebService');
	$server->handle()
?>