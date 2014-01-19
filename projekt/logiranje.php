<?php
	include_once ('klase/framework.php');
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	$smarty = new Smarty();
	session_start();
	
	if(isset($_COOKIE['user']))
	{
		$userCookie = $_COOKIE['user'];
		$smarty->assign("userCookie", $userCookie);
	}

	if (isset ($_GET['logout']))
	{
		unset($_SESSION['user']);
		session_destroy();
		
		if(isset($_COOKIE['user']))
		{
			$userCookie = $_COOKIE['user'];
			$smarty->assign("userCookie", $userCookie);
		}
		header('Location:login.php');
	} 

	if(isset($_POST['saljiLog']))
	{
		$korisnicko_ime= $_POST['korisIme'];
		$lozinka= $_POST['lozinka'];
		
		if(empty($korisnicko_ime))
		{
			$greska = array('box'=>'style="border: 1pt solid #FF0000"');
			$smarty->assign("koriIme", $greska);
			$greske++;
		}
		if(empty($lozinka))
		{
			$greska = array('box'=>'style="border: 1pt solid #FF0000"');
			$smarty->assign("pass", $greska);
			$greske++;
		}
	
		if(empty($greske))
		{
			$conn = new DBConfig();
			$korisnicko_ime = mysql_real_escape_string($korisnicko_ime);
			$lozinka = mysql_real_escape_string($lozinka);
			
			$result = mysql_query("SELECT * FROM korisnik WHERE korisnicko_ime='$korisnicko_ime' AND lozinka='$lozinka' AND status_korisnika_idstatus=8");
			
			if(mysql_num_rows($result))
			{
				mysql_query("update korisnik set neuspjesna_prijava=0 where korisnicko_ime='$korisnicko_ime'") or die(mysql_error());
				$row=mysql_fetch_array($result);
				$id_korisnika=$row['idkorisnik'];
				$nickname=$row['korisnicko_ime'];
				$slika=$row['thumb'];
				$tip=$row['tip_korisnika_idtip'];
				$_SESSION['user'] = $id_korisnika;
				$_SESSION['nickname']=$nickname;
				$_SESSION['pict']=$slika;
				$_SESSION['type']=$tip;
					
				if (isset($_POST['zapamti'])) 
				{
					setcookie("user", $nickname, time() + 60*60*60);
				}
				else
				{
					setcookie("user", $nickname, time() - 60*60*60*2);
				}
				header('Location:datomala.php');
			}
			else
			{
				$result = mysql_query("SELECT * FROM korisnik WHERE korisnicko_ime='$korisnicko_ime' AND status_korisnika_idstatus=8");
				if(mysql_num_rows($result))
				{
					$row= mysql_fetch_array($result);
					$nLog = $row['neuspjesna_prijava'];
					if($nLog < 3)
					{
						$nLog++;
						mysql_query("update korisnik set neuspjesna_prijava='$nLog' where korisnicko_ime='$korisnicko_ime'") or die(mysql_error());
					}
					if($nLog >= 3)
					{
						mysql_query("update korisnik set status_korisnika_idstatus=6 where korisnicko_ime='$korisnicko_ime'") or die(mysql_error());
						$smarty->assign("noLogin", "Korisnički račun blokiran!");
						$smarty->assign("title", "Prijava");
						$smarty->display('login.tpl');
					}
				}
				
				$smarty->assign("noLogin", "Nepostojeći korisnik / pogrešna lozinka!");
				$greske++;
				$smarty->assign("title", "Prijava");
				$smarty->display('login.tpl');
			}
		}
		else
		{
			$smarty->assign("title", "Prijava");
			$smarty->display('login.tpl');
		}
}
$conn::zatvori();

?>