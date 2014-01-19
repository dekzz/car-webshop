<?php
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	require_once 'klase/framework.php';
	require_once 'openid.php';
	session_start();
		
	$openid = new LightOpenID("http://arka.foi.hr/");

	$openid->identity = 'https://www.google.com/accounts/o8/id';
	$openid->required = array(
	  'namePerson/first',
	  'namePerson/last',
	  'contact/email',
	);

	/* 
	Yahoo : https://me.yahoo.com
	AOL : https://www.aol.com
	WordPress : http://YOURBLOG.wordpress.com
	LiveJournal : http://www.livejournal.com/openid/server.bml
	*/

	$openid->returnUrl = 'http://arka.foi.hr/WebDiP/2011/vjezbe_10/datomala/openIDanswer.php';
	
	/*
	$veza = "<?php echo $openid->authUrl() ?>";
	$smarty->assign("veza", $veza);
	$smarty->display("openIDlogin.tpl");
	*/
?>
<h3>Odaberite OpenID providera</h3>
	<ul>
		<li>
			<a href="<?php echo $openid->authUrl() ?>">Google</a>
		</li>
		<li>
			<a>Yahoo</a>
		</li>
		<li>
			<a>AOL</a>
		</li>
		<li>
			<a>WordPress</a>
		</li>
		<li>
			<a>LiveJournal</a>
		</li>
	</ul>