<?php
	include_once ('klase/framework.php');
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	session_start();
	$smarty = new Smarty();
	
	$conn = new DBConfig();
	
	$page=0;
	if (isset($_GET['page']))
	{
		$page = mysql_real_escape_string($_GET['page']);
		$page = $page - 1;
	}
		
	$pomak = $page * 10;
	$limit = 10;
	
	$result = mysql_query("SELECT * FROM konfiguracije"); 
	$nrRows = mysql_num_rows($result);
	$nrPages= ceil($nrRows/10) +1;

	$rs = mysql_query("select idkonfiguracije, automobil_idautomobil, dijelovi_iddio from konfiguracije LIMIT $limit OFFSET $pomak");
	
	$conf = array();
	while($row = mysql_fetch_array($rs))
	{
		$conf [] = $row;
	}
	
	if ($nrPages > 5)
	{
		$first = max($page - 2, 1);
		$last = min($nrPages, $page + 5);		
	}
	else
	{
		$first = 1;
		$last = $nrPages;
	}

	$smarty->assign("first", $first);
	$smarty->assign("last", $last);
	$smarty->assign("nrPages", $nrPages);
	$smarty->assign("page", $page + 1);		
	
	$conn::zatvori();
	
	$smarty->assign("conf", $conf);
	$smarty->assign("title", "Konfiguracije");
	$smarty->display("konfiguracije.tpl");
?>