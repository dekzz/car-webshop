{include file="_header.tpl"}
	<div id='log'>
		<a href="openIDlogin.php">OpenID</a>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
				&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a href="lostPass.php">Lozinka??</a>
		<form action='logiranje.php' method='post'>
			<p>
				<input id='korisIme' type='text' name='korisIme' {$koriIme.box} value='{if (isset($userCookie))}{$userCookie}{/if}'/>
				<input id='passw' type='password' name='lozinka' {$pass.box}/> <br/>
				<input id='zapamti' type="checkbox" name="zapamti" value="ZapamtiMe"/> 
				Zapamti me 
				&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
				<input id='saljiLog' type='submit' name='saljiLog' value='Login'/> <br/>
				<span class='greska'>{$noLogin}</span>
			</p>
		</form>
	</div>
{include file="_footer.tpl"}