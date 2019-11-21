<?php
	require_once __DIR__ . "/webServiceAutoload.php";
	require_once __DIR__ . "/webservice/DadosPessoaisWebService.php";
	
	$server = new Zend_Rest_Server();
	$server->setClass('DadosPessoaisWebService');
	$server->handle()
?>