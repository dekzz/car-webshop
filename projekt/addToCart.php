<?php
	include_once ('klase/framework.php');
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';

	$smarty = new Smarty();
	session_start();
	
	$loggedID = $_SESSION['user'];
		
	$conn = new DBConfig();
	
	$checkID = mysql_query("SELECT * FROM korisnik WHERE idkorisnik='$loggedID'") or die();
	while ($row = mysql_fetch_assoc($checkID))
	{
		$cartUser = $row['idkorisnik'];
	}
	
	if (isset($_GET['id']))
	{
		$itemID = $_GET['id'];
	}
	
	
	if(isset($_POST['add']))
	{
		if(isset($_POST['model']))
		{
			$naziv = $_POST['naziv'] . " " . $_POST['model'];
		}
		if(isset($_POST['opis']))
		{
			$naziv = $_POST['naziv'] . " " . $_POST['opis'];
		}
		$cijena = $_POST['cijena'];

		if (!isset($_SESSION['cart'][$cartUser][$itemID]))
		{
			echo $naziv;
			$kolicina = 0;
			$_SESSION['cart'][$cartUser][$itemID] = array(
				'naziv' => $naziv,
				'cijena' => $cijena,
				'kolicina' => $kolicina
				);
		}
		else
		{
			$cart = $_SESSION['cart']; 
			foreach ($cart as $i => $userID)
			{
				foreach ($userID as $itemID => $item)
				{
					echo $itemID;
					if ($item['naziv'] == $naziv)
					{
						$item['cijena'] += $cijena;
						$item['kolicina'] ++;

						$_SESSION['cart'][$cartUser][$itemID] = array(
							'naziv' => $item['naziv'],
							'cijena' => $item['cijena'],
							);
					}
				}
			}
		}
	}
	$backURL = $_POST['backURL'];
	$smarty->assign("addedToCart", "Stavka dodana u košaricu.");
	if ($backURL == 1)
	{
		$smarty->display("automobili.tpl");
	}
	if ($backURL == 2)
	{
		$smarty->display("dijelovi.tpl");
	}
	if ($backURL == 3)
	{
		$smarty->display("konfiguracije.tpl");
	}

?>