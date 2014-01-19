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
	else {
		//header("location: datomala.php?err=401");
	}
	if (isset($_GET['id']))
	{
		$id = $_GET['id'];
	}
	$xml_output = "<?xml version=\"1.0\"?>\n"; 
	$xml_output .=  "<ocjene>\n";
	$sql = mysql_query("SELECT korisnik_idkorisnik, ocjena FROM komentar_ocjena WHERE automobil_idautomobil = '$id'") or die(mysql_error());
	while ($row = mysql_fetch_assoc($sql)) 
	{
		if($row['ocjena'] != null)
		{
			$sql2 = mysql_query("SELECT korisnicko_ime FROM korisnik WHERE idkorisnik = '".$row['korisnik_idkorisnik']."'");
			$row2 = mysql_fetch_array($sql2);
			$xml_output .=  "<ocjena>\n";
			$xml_output .=  "\t\t<username>" . $row2['korisnicko_ime'] . "</username>\n"; 
			$xml_output .=  "\t\t<rate>" . $row['ocjena'] . "</rate>\n";
			$xml_output .=  "</ocjena>\n";
		}
	};

	$xml_output .=  "</ocjene>\n";
	$smarty->assign("XMLdata", $xml_output);
	$smarty->display("listXML.tpl");

?>