<?php
	include_once ('klase/framework.php');
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';

	$smarty = new Smarty();
	session_start();
		
	$conn = new DBConfig();

	if (isset($_POST['ok']))
	{
		$username = $_POST['username'];
		$email = $_POST['email'];
	}

	if (empty($username) || empty($email))
	{
		header("location:login.php");
	}
	else
	{
		$sql = mysql_query("SELECT * FROM korisnik WHERE korisnicko_ime = '$username' and e_mail='$email'");
		if(mysql_num_rows($sql))
		{
			$num = "1234567890";
			$small = "abcdefghijkmnopqrstuvwxyz";
			$caps = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			$sym = "!#$%&";
			$length = 2;
			$i = 0;
			$password = "";
			while ($i <= $length) {
				$password .= $small{mt_rand(0,strlen($small))};
				$i++;
			}
			$i = 0;
			while ($i <= $length) {
				$password .= $caps{mt_rand(0,strlen($caps))};
				$i++;
			}
			$i = 0;
			while ($i <= $length) {
				$password .= $num{mt_rand(0,strlen($num))};
				$i++;
			}
			$i = 0;
			while ($i <= $length) {
				$password .= $sym{mt_rand(0,strlen($sym))};
				$i++;
			}
			mysql_query("UPDATE korisnik SET lozinka = '$password' WHERE korisnicko_ime = '$username'");
			$sql = mysql_query("SELECT * FROM korisnik WHERE korisnicko_ime = '$username'");
			$row = mysql_fetch_assoc($sql);
			$email = $row['e_mail'];
			$ime = $row['ime'];
			$subject = "Nova lozinka za AutoConf!";
			$message = "Postovanje,  $ime!\nVasa nova lozinka je: '$password'";
			$headers = 'From: nwebmaster@webdip_122.foi' . 'X-Mailer: datomala-webdip';
			mail($email, $subject, $message, $headers);
			
			$log = "errorlog.txt";
			$fileHandler = fopen($log, 'a') or die ();
			$korisnik = $_SESSION['user'];
			$upit = mysql_query("SELECT korisnicko_ime, ime, prezime, idkorisnik FROM korisnik WHERE idkorisnik = '$korisnik'");
			$korisnik= mysql_fetch_array($upit);
			$time = getTime();
			$zapis = date("d.m.Y H:i:s",$time ). " korisnik " . $korisnik['idkorisnik'] . " " . $korisnik['korisnicko_ime'] . "  ->  " . $korisnik['ime'] . "  " . $korisnik['prezime'] . ", je pokušao mijenjati podatke na stranici: " . $_SERVER['REQUEST_URI'] . "\n";
			
			fwrite($fileHandler, $zapis);
			fclose($fileHandler);
			
			$smarty->assign("newPass", "Ukoliko ste unijeli dobro korisničko ime an mail adresu će vam stići nova lozinka.");
			$smarty->display("lostPass.tpl");
		}
		else
		{
			header("location:login.php");
		}
	}

?>