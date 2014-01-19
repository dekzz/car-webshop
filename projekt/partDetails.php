<?php
	include_once ('klase/framework.php');
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	session_start();
	$smarty = new Smarty();
	
	$conn = new DBConfig();

	if (isset($_SESSION['user']))
	{
		$user = $_SESSION['user'];
	}
	else {
		header("location: login.php");
	}
		
	if (isset($_GET['id']))
	{
		$partId = $_GET['id'];
	}

	$sql = mysql_query("SELECT * FROM dijelovi WHERE iddio = '$partId'") or die(mysql_error());
	
	while ($row = mysql_fetch_assoc($sql))
	{
		$part[] = $row;
	} 
	echo $part['iddio'];
	
	$sql = mysql_query("SELECT * FROM dijelovi WHERE iddio = '$partId'") or die(mysql_error());
	$dio = mysql_fetch_assoc($sql);
	
	$sql = mysql_query("SELECT SUM(ocjena) AS suma FROM komentar_ocjena WHERE dijelovi_iddio = '$partId'");
	$sql2 = mysql_query("SELECT COUNT(ocjena) AS count FROM komentar_ocjena WHERE dijelovi_iddio = '$partId'") or die(mysql_error());
	$sql3 = mysql_query("SELECT naziv, model FROM automobil WHERE idautomobil = '$dio[automobil_idautomobil]'") or die(mysql_error());

	$sum = mysql_fetch_assoc($sql);
	$row = mysql_fetch_assoc($sql2);
	
	if($part['akcija'] > 0)
	{
		$akcija = $part['cijena']*(1-($part['akcija']/100));
	}
	if($part['akcija'] < 0)
	{
		$akcija = $part['cijena']*(1+($part['akcija']/100));
	}
	
	while ($auto = mysql_fetch_assoc($sql3))
	{
	   $dioZa[] = $auto;
	}

	if ($row['count'] != 0)
	{
		$prosjek = $sum['suma']/$row['count'];
	}
	
	$smarty->assign("part", $part);
	$smarty->assign("dioZa", $dioZa);
	$smarty->assign("akcija", $akcija);
	$smarty->assign("prosjek", $prosjek);
	$smarty->assign("title", "Detalji o dijelu");
	$smarty->display("partDetails.tpl");
?>