{include file="_header.tpl"}
	<div>
		<form action='recoverPass.php' method='post'>
			<table border='0'>
				<tr>
					<td><label for='username'>Korisničko ime:</label></td>
					<td>
						<input id='username' type='text' name='username'/>
					</td>
				</tr>
				<tr>
					<td><label for='email'>E-mail:</label></td>
					<td>
						<input id='email' type='text' name='email'/>
					</td>
				</tr>
			</table>
			<input id='ok' type='submit' name='ok' value='Šalji'/>
		</form>
	</div>
{include file="_footer.tpl"}