<?php
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	
	$smarty = new Smarty();
	session_start();
	
	$smarty->assign("title", "Prijava");
	
	if (isset($_COOKIE['user']));
	{
		$userCookie = $_COOKIE['user'];
		$smarty->assign("userCookie", $userCookie);
	}
	
	$smarty->display("login.tpl");
?>