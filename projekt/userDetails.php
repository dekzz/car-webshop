<?php
	include_once ('klase/framework.php');
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	session_start();
	$smarty = new Smarty();
	
	$conn = new DBConfig();

	if (isset($_SESSION['user']))
	{
		$korisnik = $_SESSION['user'];
	}
	else 
	{
		header("location: login.php");
	}
		
	if (isset($_GET['id']))
	{
		$userID = $_GET['id'];
	}

	$sql = mysql_query("SELECT * FROM korisnik WHERE idkorisnik = '$userID'");

	$korisnik = array();
	while ($row = mysql_fetch_array($sql))
	{
		$korisnik[] = $row;
	} 
	
	$smarty->assign("user", $korisnik);
	$smarty->assign("title", "Detalji o korisniku");
	$smarty->display("userDetails.tpl");
?>