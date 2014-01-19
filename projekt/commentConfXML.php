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

	$xml_output = "<?xml version=\"1.0\"?>\n"; 
	$xml_output .=  "<comments>\n";
	$sql = mysql_query("SELECT * FROM komentar_ocjena WHERE konfiguracije_idkonfiguracije = '$id'") or die(mysql_error());
	while ($row = mysql_fetch_assoc($sql)) 
	{
		$sql2 = mysql_query("SELECT korisnicko_ime FROM korisnik WHERE idkorisnik = '".$row['korisnik_idkorisnik']."'");
		$row2 = mysql_fetch_array($sql2);
		if($row['tekst'] != null)
		{
			$xml_output .=  "<comment>\n";
			$xml_output .=  "\t\t<id>" . $row['idkomocj'] . "</id>\n";
			$xml_output .=  "\t\t<username>" . $row2['korisnicko_ime'] . "</username>\n"; 
			$xml_output .=  "\t\t<text>" . $row['tekst'] . "</text>\n"; 
			$xml_output .=  "\t\t<vrijeme>" . $row['datum'] . "</vrijeme>\n";
			$xml_output .=  "</comment>\n";
		}
	};

	$xml_output .=  "</comments>\n";
	$smarty->assign("XMLdata", $xml_output);
	$smarty->display("listXML.tpl");

?>













