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
	else 
	{
		header("location: login.php");
	}
		
	if (isset($_GET['id']))
	{
		$confId = $_GET['id'];
	}

	$sql = mysql_query("SELECT * FROM konfiguracije WHERE idkonfiguracije = '$confId'") or die();
	while ($row = mysql_fetch_assoc($sql))
	{
		$conf[] = $row;
	} 
	echo $conf['idkonfiguracije'];
	
	$sql = mysql_query("SELECT * FROM konfiguracije WHERE idkonfiguracije = '$confId'") or die();
	$data = mysql_fetch_assoc($sql);
	
	$sql = mysql_query("SELECT SUM(ocjena) AS suma FROM komentar_ocjena WHERE konfiguracije_idkonfiguracije = '$confId'")or die(mysql_error());
	$sql2 = mysql_query("SELECT COUNT(ocjena) AS count FROM komentar_ocjena WHERE konfiguracije_idkonfiguracije = '$confId'") or die(mysql_error());
	$sql3 = mysql_query("SELECT * FROM automobil WHERE idautomobil = '$data[automobil_idautomobil]'") or die(mysql_error());
	$sql4 = mysql_query("SELECT * FROM dijelovi WHERE iddio = '$data[dijelovi_iddio]'") or die(mysql_error());
	$sql5 = mysql_query("SELECT korisnicko_ime FROM korisnik WHERE idkorisnik = '$data[korisnik_idkorisnik]'") or die(mysql_error());
	$sql6 = mysql_query("SELECT cijena FROM automobil WHERE idautomobil = '$data[automobil_idautomobil]'") or die(mysql_error());
	$sql7 = mysql_query("SELECT cijena FROM dijelovi WHERE iddio = '$data[dijelovi_iddio]'") or die(mysql_error());

	$sum = mysql_fetch_array($sql);
	$row = mysql_fetch_array($sql2);
	$autoPrice = mysql_fetch_array($sql6);
	$dioPrice = mysql_fetch_array($sql7);
	$cijena = $autoPrice['cijena']+$dioPrice['cijena'];
	
	while ($car = mysql_fetch_array($sql3))
	{
	   $auto[] = $car;
	}
	
	while ($part = mysql_fetch_array($sql4))
	{
	   $dio[] = $part;
	}
	
	while ($user = mysql_fetch_array($sql5))
	{
	   $korisnik[] = $user;
	}
	
	if ($row['count'] != 0)
	{
		$prosjek = $sum['suma']/$row['count'];
	}
	
	$smarty->assign("conf", $conf);
	$smarty->assign("korisnik", $korisnik);
	$smarty->assign("auto", $auto);
	$smarty->assign("dio", $dio);
	$smarty->assign("cijena", $cijena);
	$smarty->assign("prosjek", $prosjek);
	$smarty->assign("title", "Detalji o konfiguraciji");
	$smarty->display("confDetails.tpl");
?>