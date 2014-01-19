<?php
	include_once ('klase/framework.php');
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	session_start();
	$smarty = new Smarty();
	
	$conn = new DBConfig();
	
	$id_loged = $_SESSION['user'];
	$id_check = mysql_query("SELECT tip_korisnika_idtip FROM korisnik WHERE idkorisnik='$id_loged'") or die (mysql_error());
	$kor=mysql_fetch_array($id_check);

	$sql = mysql_query("SELECT * FROM automobil") or die (mysql_error());
	$nrow = mysql_num_rows($sql);

	$xml_output = "<?xml version=\"1.0\"?>\n"; 
	$xml_output .=  "<cars>\n";
	while($row = mysql_fetch_assoc($sql)) 
	{
		$sql2 = mysql_query("SELECT korisnicko_ime FROM korisnik WHERE idkorisnik = '$row[korisnik_idkorisnik]'");
		$row2 = mysql_fetch_array($sql2);
		$xml_output .=  "<car>\n";
		$xml_output .=  "\t\t<tip>" . $kor['tip_korisnika_idtip'] . "</tip>\n";
		$xml_output .=  "\t\t<rb>" . $row['idautomobil'] . "</rb>\n"; 
		$xml_output .=  "\t\t<kreator>" . $row2['korisnicko_ime'] . "</kreator>\n";
		$xml_output .=  "\t\t<naziv>" . $row['naziv'] . "</naziv>\n";
		$xml_output .=  "\t\t<model>" . $row['model'] . "</model>\n";
		$xml_output .=  "\t\t<cijena>" . $row['cijena'] . "</cijena>\n";
		$xml_output .=  "\t\t<thumb>" . $row['path_thumb'] . "</thumb>\n";
		$xml_output .=  "</car>\n";
	}
	$xml_output .=  "</cars>\n";
	$smarty->assign("XMLdata", $xml_output);
	$smarty->display("listXML.tpl")
?>