<?php

include_once ('klase/framework.php');
require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';

$smarty = new Smarty();
session_start();

$conn = new DBConfig();

$url_code = $_SERVER['QUERY_STRING'];
$sql ="SELECT * FROM korisnik";
$check = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_array($check))
{
	if ($url_code == $row['aktivKod'])
	{
		$today = date("Y-m-d H:i:s");
		$danas = strtotime($today);
		$istek = strtotime($row['aktivDatum']);
		if ($danas > $istek)
		{
			$_SESSION['istekao'] = true;
		}
		else
		{
		$aktivLink ['prihvaceno'] = true;
		mysql_query("UPDATE korisnik SET status_korisnika_idstatus = 8 WHERE aktivKod = $url_code");
		mysql_query("UPDATE korisnik SET aktivKod = 'NULL'  WHERE aktivKod = $url_code");
		}
		$smarty->assign("regUspjesna","Registracija uspješna!");
		$smarty->assign("title", "Aktivacija");
		$smarty->display('aktivacija.tpl');
	}
}
$conn::zatvori();
	
if (!$aktivLink['prihvaceno'])
{
	$smarty->assign("regOdbijena","Registracija odbijena!");
	$smarty->assign("title", "Aktivacija");
	$smarty->display('aktivacija.tpl');
}

if($_SESSION['istekao'])
{
	$smarty->assign("regIstekla","Istekao je aktivacijski kod za registraciju!");
	$smarty->assign("title", "Aktivacija");
	$smarty->display('aktivacija.tpl');
}

?>