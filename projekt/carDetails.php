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
		$carId = $_GET['id'];
	}

	$sql = mysql_query("SELECT * FROM automobil WHERE idautomobil = '$carId'");

	while ($row = mysql_fetch_assoc($sql))
	{
		$car[] = $row;
	} 
	$sql2 = mysql_query("SELECT COUNT(ocjena) AS count FROM komentar_ocjena WHERE automobil_idautomobil = '$carId'") or die(mysql_error());
	$sql = mysql_query("SELECT SUM(ocjena) as suma FROM komentar_ocjena WHERE automobil_idautomobil = '$carId'");

	$row = mysql_fetch_assoc($sql2);
	$sum = mysql_fetch_assoc($sql);
	
	if($car['akcija'] > 0)
	{
		$akcija = $car['cijena']*(1-($car['akcija']/100));
	}
	if($car['akcija'] < 0)
	{
		$akcija = $car['cijena']*(1+($car['akcija']/100));
	}
	
	if ($row['count'] != 0)
	{
		$prosjek = $sum['suma']/$row['count'];
	}
	
	$smarty->assign("carId", $carId);
	$smarty->assign("car", $car);
	$smarty->assign("akcija", $akcija);
	$smarty->assign("prosjek", $prosjek);
	$smarty->assign("title", "Detalji o automobilu");
	$smarty->display("carDetails.tpl");
?>