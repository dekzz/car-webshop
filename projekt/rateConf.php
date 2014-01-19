<?php
	include_once ('klase/framework.php');
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';

	$smarty = new Smarty();
	session_start();

	$conn = new DBConfig();

	if (isset($_SESSION['user']))
	{
		$user = $_SESSION['user'];
	}
	if (isset($_GET['id']))
	{
		$id = $_GET['id'];
	}
	if (isset($_GET['rate']))
	{
		$rate = $_GET['rate'];
	}

	$upit = "SELECT * FROM komentar_ocjena WHERE korisnik_idkorisnik = '$user' AND konfiguracije_idkonfiguracije = '$id'";
	$upit = mysql_query($upit);
	if (mysql_num_rows($upit) > 0)
	{
		$sql2 = mysql_query("UPDATE komentar_ocjena SET ocjena = '$rate' WHERE korisnik_idkorisnik = '$user' AND konfiguracije_idkonfiguracije = '$id' ") or die(mysql_error());
	}
	else 
	{
		$sql2 = mysql_query("INSERT into komentar_ocjena(korisnik_idkorisnik, konfiguracije_idkonfiguracije, ocjena) VALUES('$user', '$id', '$rate')") or die(mysql_error());
	}
?>