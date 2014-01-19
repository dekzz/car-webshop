<?php
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	include_once ('klase/framework.php');
	$smarty = new Smarty();
	session_start();


	if (isset($_GET['editID']))
	{		
		$logedID = $_SESSION['user'];
		
		$conn = new DBConfig();
		
		$checkID = mysql_query("SELECT * FROM korisnik WHERE idkorisnik='$logedID'") or die();
		$row= mysql_fetch_array($checkID);
		$logedIDusername = $row[7];
		$logedIDfirstName = $row[3];
		$logedIDlastName = $row[4];
		$logedIDtype = $row[2];
		if($_GET['editID'] != $logedID && $logedIDtype != 3)
		{				
			$log = "errorlog.txt";
			$fileHandler = fopen($log, 'a') or die ();
			$korisnik = $_SESSION['user'];
			$upit = mysql_query("SELECT korisnicko_ime, ime, prezime, idkorisnik FROM korisnik WHERE idkorisnik = '$korisnik'");
			$korisnik = mysql_fetch_array($upit);
			$time = getTime();
			$zapis = date("d.m.Y H:i:s",$time ). " korisnik " . $korisnik['idkorisnik'] . " " . $korisnik['korisnicko_ime'] . "  ->  " . $korisnik['ime'] . "  " . $korisnik['prezime'] . ", je pokušao mijenjati podatke na stranici: " . $_SERVER['REQUEST_URI'] . "\n";
			
			fwrite($fileHandler, $zapis);
			fclose($fileHandler);
			$smarty->assign("title", "Početna");
			$smarty->display('datomala.tpl');
		} 
		else
		{		
			$id=$_GET['editID'];
			
			$sql = mysql_query("SELECT * FROM korisnik WHERE idkorisnik='$id'") or die();
			$row= mysql_fetch_array($sql);
			$conn::zatvori();		
			
			$smarty->assign("logedIDstatus", $row[1]);
			$smarty->assign("logedIDtype", $row[2]);
			$smarty->assign("logedIDfirstName",$row[3]);
			$smarty->assign("logedIDlastName",$row[4]);
			$smarty->assign("logedIDemail", $row[5]);
			$smarty->assign("logedIDusername",$row[8]);
			$smarty->assign("logedIDpassword", $row[9]);
			$smarty->assign("title", "Uređivanje");
			$smarty->display('editUser.tpl');
		}
	}
?>