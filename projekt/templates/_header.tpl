<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel='stylesheet' type='text/css' href='css/style.css'/>
		<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
		<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu-v.css" />
		
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
		<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
		<script type="text/javascript" src="js/paginationJQuery.js"></script>
		<script type="text/javascript" src="js/datomala.js"></script>
		
		<script type="text/javascript">
		{literal} 
			ddsmoothmenu.init({
				mainmenuid: "smoothmenu1", //menu DIV id
				orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
				classname: 'ddsmoothmenu', //class added to menu's outer DIV
				//customtheme: ["#1c5a80", "#18374a"],
				contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
			})

			ddsmoothmenu.init({
				mainmenuid: "smoothmenu2", //Menu DIV id
				orientation: 'v', //Horizontal or vertical menu: Set to "h" or "v"
				classname: 'ddsmoothmenu-v', //class added to menu's outer DIV
				//customtheme: ["#804000", "#482400"],
				contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
			})
		{/literal} 
		</script>
		
		<title>
			{$title}
		</title>
	</head>
	<body>
		<h1 id='header'>
			<a href='datomala.php'>Davor Tomala - konfiguracija automobila</a>
		</h1>
		
		<div id='log'>
			{if !isset ($smarty.session.user)}
				<a href="openIDlogin.php">OpenID</a>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
				&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a href="lostPass.php">Lozinka??</a>
				<form action='logiranje.php' method='post'>
					<p>
						<input id='korisIme' type='text' name='korisIme' {$koriIme.box} value='{if isset($userCookie)}{$userCookie}{/if}'/>
						<input id='pass' type='password' name='lozinka' {$pass.box}/> <br/>
						<input id='zapamti' type="checkbox" name="zapamti" value="ZapamtiMe"/> 
						Zapamti me 
						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
						<input type='submit' name='saljiLog' value='Login'/> <br/>
						<span class='greska'>{$noLogin}</span>
					</p>
				</form>
			{/if}
			{if isset ($smarty.session.user)}
				<img src="{$smarty.session.pict}" height='40' width='40'> <a href="editUser.php?editID={$smarty.session.user}"> {$smarty.session.nickname} </a> (<a href="logiranje.php?logout=true">Logout</a>)
			{/if}
		</div>
		
		<div id="smoothmenu1" class="ddsmoothmenu">
			<ul>
			<li><a href='datomala.php'>Početna</a></li>
			{if !isset ($smarty.session.user)}
				<li>
					<a href='datomala_reg.php'>Registracija</a>
				</li>
			{/if}
			<li><a href="#">Popisi</a>
			  <ul>
				  <li><a href='automobili.php'>Automobili</a></li>
				  <li><a href='dijelovi.php'>Dijelovi</a></li>
				  {if isset ($smarty.session.user)}
					<li><a href='konfiguracije.php'>Konfiguracije</a></li>
					<li><a href='mojeKonfiguracije.php'>Moje konfiguracije</a></li>
					<li><a href='korisnici.php'>Korisnici</a></li>
				  {/if}
			  </ul>
			</li>
			{if isset ($smarty.session.user) && ($smarty.session.type == 1)}
				<li><a href="unosKonfiguracija.php">Kreiranje konfiguracije</a></li>
			{/if}
			{if isset($smarty.session.user) && ($smarty.session.type > 1)}
				<li><a href="#">Unos</a>
				  <ul>
					  <li><a href="unosVozila.php">Unos vozila</a></li>
					  <li><a href="unosDijelova.php">Unos dijelova</a></li>
					  <li><a href="unosKonfiguracija.php">Unos konfiguracija</a></li>
				  </ul>
				</li>
			{/if}
			{if isset($smarty.session.user) && ($smarty.session.type == 3)}
				<li><a href="#">Admin panel</a>
				  <ul>
					 <li><a href="time.php">Vrijeme</a></li>
					 <li><a href="errorlog.php">Dnevnik</a></li>
				  </ul>
				</li>
			{/if}
			<li><a href='datomala_doc.php'>Dokumentacija</a></li>
			<li><a href='datomala_osobno.php'>Kreator</a></li>
			<br style="clear: left" />
		</div>
		
		{if (isset($cart))}
			<div class = 'shoppingCart'>
				<table class = 'tablica'>
					<tr>
						<td colspan = "2" class = 'cartName'> Košarica </td>
					</tr>
					{if (!isset($userList))}
						<tr>
							<td class = 'cartItems'>Košarica je prazna!</td><br/>
						</tr>
					{/if}
					{if (isset($userList))}
						<tr>
							<td>Naziv</td><td> Cijena </td>
						</tr>
						{section name=i loop=$userList}
							<tr>
								<td class = 'cartItems'>{if (isset($userList[i].naziv))} {$userList[i].naziv} {/if}</td><td class = 'cartItems'> {if (isset($userList[i].cijena))} {$userList[i].cijena} {/if}</td><td class = 'cartItems'> {if (isset($userList[i].kolicina))} {$userList[i].kolicina} {/if}</td>
							</tr>
						{/section}
						<tr>
							<td colspan = "2" class = 'cartName'>Ukupno: {if (isset($ukupno))}{$ukupno}{/if} kn</td><br/>
						</tr>
					{/if}
				</table>
				</ul>
			</div>
		{/if}