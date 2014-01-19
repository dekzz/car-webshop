<?php
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	session_start();
	$smarty = new Smarty();
	
	if (!isset($_SESSION['user']))
	{
		$smarty->assign("restrict","Za unos vozila se potrebno prijaviti!");
		$smarty->assign("title", "Početna");
		$smarty->display('datomala.tpl');
	}
	
	if(isset($_SESSION['user']))
	{
		if($_SESSION['type'] == 1)
		{
			$smarty->assign("restrict","Običan korisnik ne može unositi vozila");
			$smarty->assign("title", "Početna");
			$smarty->display('datomala.tpl');
		}
		if($_SESSION['type'] > 1)
		{
			$smarty->assign("title", "Unos vozila");
			$smarty->display("unosVozila.tpl");
		}
	}

?>