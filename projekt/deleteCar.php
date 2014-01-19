<?php
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	include_once ('klase/framework.php');
	$smarty = new Smarty();
	session_start();


	if (isset($_GET['deleteID']))
	{		
		$logedID = $_SESSION['user'];
		
		$conn = new DBConfig();
		
		$checkID = mysql_query("SELECT * FROM korisnik WHERE idkorisnik='$logedID'") or die(mysql_error());
		$row= mysql_fetch_array($checkID);
		$logedIDusername = $row[7];
		$logedIDfirstName = $row[3];
		$logedIDlastName = $row[4];
		$logedIDtype = $row[2];
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
			$smarty->assign("title", "Poèetna");
			$smarty->display('datomala.tpl');
		} 
		else
		{		
			$id=$_GET['deleteID'];
			
			$sql = mysql_query("SELECT * FROM automobil WHERE idautomobil='$id'") or die(mysql_error());
			if(mysql_num_rows($sql))
			{
				mysql_query("DELETE FROM automobil WHERE idautomobil='$id'") or die(mysql_error());
			}
			
			$conn::zatvori();		
			
			header('Location: automobili.php');
		}
	}
?>