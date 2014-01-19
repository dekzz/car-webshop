<?php
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	include_once ('recaptchalib.php');
	$smarty = new Smarty();
	session_start();
	
	$publickey="6Ld_rtASAAAAAJNlALkuPEmf2Tt7MrWPOWBoLFqS";
	$privatekey="6Ld_rtASAAAAAHr-9yTZ-qubT45qy81Do7aYT3WU";
	
	$smarty->assign("recaptcha", recaptcha_get_html($publickey, $error));
	$smarty->assign("title", "Registracija");
	$smarty->display("datomala_reg.tpl");
?>