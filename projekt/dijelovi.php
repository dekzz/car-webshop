<?php
	include_once ('klase/framework.php');
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	session_start();
	$smarty = new Smarty();
	
	$conn = new DBConfig();
	
	$page=0;
	if (isset($_GET['page']))
	{
		$page = mysql_real_escape_string($_GET['page']);
		$page = $page - 1;
	}
		
	$pomak = $page * 10;
	$limit = 10;
	
	$result = mysql_query("SELECT * FROM dijelovi"); 
	$nrRows = mysql_num_rows($result);
	$nrPages= ceil($nrRows/10) +1;

	$rs = mysql_query("select * from dijelovi LIMIT $limit OFFSET $pomak");
	
	$parts = array();
	while($row = mysql_fetch_array($rs))
	{
		$parts [] = $row;
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
	$id_check = mysql_query("SELECT tip_korisnika_idtip FROM korisnik WHERE idkorisnik='$id_loged'") or die();
	$row=mysql_fetch_array($id_check);
	$smarty->assign("tip",$row[0]);
	
	$conn::zatvori();
	
	$smarty->assign("parts", $parts);
	$smarty->assign("title", "Dijelovi");
	$smarty->display("dijelovi.tpl");
?>