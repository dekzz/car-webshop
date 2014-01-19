<?php
	include_once ('klase/framework.php');
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	require_once('recaptchalib.php');
	session_start();
	$smarty = new Smarty();
	
	$mailhide_pubkey = "017n1AUnFe7fruTarcxS8oSg==";
    $mailhide_privkey = "e1e0dc4ae49485671453b07fb96dc757";
	
	if (!isset($_SESSION['user']))
	{
		$smarty->assign("restrict","Za pregled korisnika se potrebno prijaviti!");
		$smarty->assign("title", "Početna");
		$smarty->display('datomala.tpl');
	}
	else
	{
		$conn = new DBConfig();
		
		$page=0;
		if (isset($_GET['page']))
		{
			$page = mysql_real_escape_string($_GET['page']);
			$page = $page - 1;
		}
			
		$pomak = $page * 10;
		$limit = 10;
		
		$result = mysql_query("SELECT * FROM korisnik"); 
		$nrRows = mysql_num_rows($result);
		$nrPages= ceil($nrRows/10) +1;

		$rs = mysql_query("select * from korisnik LIMIT $limit OFFSET $pomak");
		
		$users = array();
		while($row = mysql_fetch_array($rs))
		{
			$row['e_mail'] = recaptcha_mailhide_html ($mailhide_pubkey,
													 $mailhide_privkey,
													 $row['e_mail']);
			$users [] = $row;
		}
		
		if ($nrPages > 5)
		{
			$first = max($page - 2, 1);
			$last = min($nrPages, $page + 5);		
		}
		else
		{
			$first = 1;
			$last = $nrPages;
		}

		$smarty->assign("first", $first);
		$smarty->assign("last", $last);
		$smarty->assign("nrPages", $nrPages);
		$smarty->assign("page", $page + 1);		
		
		$id_loged = $_SESSION['user'];
		$id_check = mysql_query("SELECT * FROM korisnik WHERE idkorisnik='$id_loged'") or die();
		$row=mysql_fetch_array($id_check);
		$smarty->assign("tip",$row[2]);
		$conn::zatvori();
		
		$smarty->assign("users", $users);
		$smarty->assign("title", "Korisnici");
		$smarty->display("korisnici.tpl");
	}
?>