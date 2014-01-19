<?php
session_start();
require_once 'openid.php';
require_once 'klase/framework.php';
require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';

$smarty = new Smarty();

$openid = new LightOpenID("http://arka.foi.hr/");
 
if ($openid->mode) 
{
    if ($openid->mode == 'cancel')
	{
        echo "Korisnik je prekinuo autentikaciju!";
    }
	elseif($openid->validate())
	{
        $data = $openid->getAttributes();
        $email = $data['contact/email'];
        $first = $data['namePerson/first'];
		$last = $data['namePerson/last'];
		$oidUser = $_SESSION['openIDuser'];
		echo "<h1>Dobrodošli, $first $last!</h1>";
		echo "Informacije o korisniku : $oidUser <br/>";
        echo "Identitet : $openid->identity <br/>";
		echo "Ime i prezime : $first $last <br/>";
        echo "Email : $email <br/><br/>";
		
		/*
		$conn = new DBConfig();
		
		$result = mysql_query("SELECT * FROM oidUser WHERE ime='$first' AND prezime='$last' AND email='$email'");
		
		if(!mysql_num_rows($result))
		{
			mysql_query("insert into oidUser (ime, prezime, email, status_korisnika_idstatus, tip_korisnika_idtip) values ('$first', '$last', '$email', '8', '1'") or die(mysql_error());
		}
		
		$conn::zatvori();
		
		$smarty->assign("ime", $first);
		$smarty->assign("prezime", $last);
		$smarty->assign("email", $email);
		$smarty->display("openIDanswer.tpl");
		*/
    } 
	else
	{
        echo "Korisnik nije prijavljen!";
    }
} 
else
{
	echo "<h1>Zabranjen pristup!</h1>";
    echo "Prijavite se na <a href='http://arka.foi.hr/WebDiP/2011/vjezbe_10/datomala/login.php'>početnoj stranici</a>!";
}
?>