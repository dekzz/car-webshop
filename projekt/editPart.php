<?php
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	include_once ('klase/framework.php');
	$smarty = new Smarty();
	session_start();

	if (isset($_GET['editID']))
	{		
		$logedID = $_SESSION['user'];
		
		$conn = new DBConfig();
		
		$checkID = mysql_query("SELECT tip_korisnika_idtip FROM korisnik WHERE idkorisnik='$logedID'") or die();
		$row = mysql_fetch_array($checkID);
		$logedIDtype = $row[0];
		if($logedIDtype != 3)
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
			
			$sql = mysql_query("SELECT * FROM dijelovi WHERE iddio='$id'") or die();
			$row= mysql_fetch_array($sql);
			$conn::zatvori();		
			
			$smarty->assign("partName", $row['naziv']);
			$smarty->assign("partDesc", $row['opis']);
			$smarty->assign("partPrice",$row['cijena']);
			$smarty->assign("partAction", $row['akcija']);
			$smarty->assign("title", "Uređivanje");
			$smarty->display('editPart.tpl');
		}
	}
?>