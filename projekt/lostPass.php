<?php
	include_once ('klase/framework.php');
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	$smarty = new Smarty();
	session_start();
	
	$smarty->display('lostPass.tpl');
?>