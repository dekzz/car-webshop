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

	if($_SERVER['REQUEST_METHOD'] === 'POST')
	{
		$txt = $_POST['txt'];
	}

	//vrijeme virtualno
	//$cr_date = getTime();
	//$cr_d = date("d.m.Y H:i:s",$cr_date);
	//$exp_act = date('Y-m-d H:i:s', strtotime($cr_d . ' +1 day'));
	$cr_date = date("Y-m-d H:i:s");
	$exp_act = date('Y-m-d H:i:s', strtotime($cr_date));

	//unos komentara
	$sql = "INSERT INTO komentar_ocjena(korisnik_idkorisnik, dijelovi_iddio, datum, tekst) VALUES('$user', '$id', '$exp_act', '$txt')";
	$sql = mysql_query($sql) or die(mysql_error());                                                                 
?>