<?php
	include_once ('klase/framework.php');
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	session_start();
	
	$smarty = new Smarty();
	
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
		$korisnik= mysql_fetch_array($upit);
		$time = getTime();
		$zapis = date("d.m.Y H:i:s",$time ). " korisnik " . $korisnik['idkorisnik'] . " " . $korisnik['korisnicko_ime'] . "  ->  " . $korisnik['ime'] . "  " . $korisnik['prezime'] . ", je pokušao mijenjati podatke na stranici: " . $_SERVER['REQUEST_URI'] . "\n";
		
		fwrite($fileHandler, $zapis);
		fclose($fileHandler);
		$smarty->assign("title", "Početna");
		$smarty->display('datomala.tpl');
	} 
	else
	{		
		if(isset($_POST['search']))
		{
			$sValue = $_POST['value'];
		}
		
		$file = file("errorlog.txt");
			foreach ($file as $line) 
			{
				if(!empty($sValue))
				{
					if (substr_count($line, $sValue))
					{
						$rows .= $line . "<br/>";
					}
					if(!empty($rows))
					{
						$smarty->assign("vrijednost", $sValue);
						$smarty->assign("box", 'style="border: 1pt solid #00FF00"');
						$smarty->assign("log", $rows);
					}
					else
					{
						$smarty->assign("vrijednost", $sValue);
						$smarty->assign("box", 'style="border: 1pt solid #FF0000"');
					}
				}
				else
				{
					$rows .= $line . "<br/>";
					$smarty->assign("log", $rows);
				}
			}
		$smarty->assign("title", "Dnevnik");
		$smarty->display("errorlog.tpl");
	}
?>