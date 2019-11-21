<?php
	require_once __DIR__ . "/webServiceAutoload.php";
	require_once __DIR__ . "/webservice/UsuariosWebService.php";
	
	$server = new Zend_Rest_Server();
	$server->setClass('UsuariosWebService');
	$server->handle()
?>