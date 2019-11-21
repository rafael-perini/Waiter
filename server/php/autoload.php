<?php
	spl_autoload_register(function ($classname) {
		$filename = __DIR__ . "/bean/". $classname .".php";
		
		if (file_exists($filename)) {
			include_once($filename);
			return;
		}
		
		$filename = __DIR__ . "/dao/". $classname .".php";
		
		if (file_exists($filename)) {
			include_once($filename);
			return;
		}
	});
?>