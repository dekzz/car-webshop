<?php
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	session_start();
	$smarty = new Smarty();
	
	$smarty->assign("title", "Uloge korisnika");
	$smarty->display("ulogeKorisnika.tpl")
?>