<?php
	include_once ('klase/framework.php');
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	$smarty = new Smarty();
	session_start();
	
	$conn = new DBConfig();
	
	if (isset($_SESSION['user']))
	{
		if (isset($_SESSION['cart']))
		{
			$cart = $_SESSION['cart']; 

			foreach ($cart as $i => $userId)
			{
				foreach ($userId as $itemID => $item)
				{
					$cartItemData[] = $item;
					$ukupno += ($item['cijena']*$item['kolicina']);
				}
			}
			$smarty->assign("userList", $cartItemData);
			$smarty->assign("ukupno", $ukupno);
		}
	$smarty->assign("title", "Početna");
	$smarty->display('datomala.tpl');
	}
	else 
	{
		$smarty->display('login.tpl');
	}
	

?>