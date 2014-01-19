<?php
	include_once ('klase/framework.php');
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	session_start();
	$smarty = new Smarty();
	
	if (!isset($_SESSION['user']))
	{
		$smarty->assign("restrict","Za unos dijela se potrebno prijaviti!");
		$smarty->assign("title", "Početna");
		$smarty->display('datomala.tpl');
	}
	
	if(isset($_SESSION['user']))
	{
		if($_SESSION['type'] == 1)
		{
			$smarty->assign("restrict","Običan korisnik ne može unositi dijelove");
			$smarty->assign("title", "Početna");
			$smarty->display('datomala.tpl');
		}
		if($_SESSION['type'] > 1)
		{
			$conn = new DBConfig();
			$result = mysql_query("SELECT * FROM automobil");
			while ($row = mysql_fetch_assoc($result))
			{
			   $cars[] = $row;
			}

			if(isset($_SESSION['saved']))
			{
				$smarty->assign("saved", $_SESSION['saved']);
				unset($_SESSION['saved']);
			}
			$smarty->assign("cars", $cars);
			$smarty->assign("title", "Unos dijelova");
			$smarty->display("unosDijelova.tpl");
		}
	}

?>