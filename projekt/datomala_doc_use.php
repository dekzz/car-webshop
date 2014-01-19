<?php
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	$smarty = new Smarty();
	session_start();
	$smarty->assign("title", "UseCase dijagrami");
	$smarty->display("datomala_doc_use.tpl");
?>