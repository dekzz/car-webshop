{include file="_header.tpl"}
	<div id='sadrzaj'>
		<form enctype='multipart/form-data' action='editingCar.php' method='post'>
			<table border='0'>
				<tr>
					<td><label for='naziv'>Naziv:</label></td>
					<td>
						<input id='naziv' type='text' name='naziv' {$naziv.box} {$imeZauzeto.box} value='{$carName}'/> 
						<span class='reg'>
							{$naziv.greska}
							{$imeZauzeto.greska}
						</span>
					</td>
				</tr>
				<tr>
					<td><label for='model'>Model:</label></td>
					<td>
						<input id='model' type='text' name='model' {$model.box} value='{$carModel}'/> 
						<span class='reg'>{$model.greska}</span>
					</td>
				</tr>
				<tr>
					<td><label for='cijena'>Cijena:</label></td>
					<td>
						<input id='cijena' type='text' name='cijena' {$cijena.box} value='{$carPrice}'/> 
						<span class='reg'>{$cijena.greska}</span>
					</td>
				</tr>
				<tr>
					<td><label for='akcija'>Akcija:</label></td>
					<td>
						<input id='akcija' type='text' name='akcija' {$akcija.box} value='{$carAction}'/> 
						<span id='ajaxResponse' class='greska'>{$akcija.greska}</span>
					</td>
				</tr>
				<tr>
					<td><label for='slika'>Slika:</label></td>
					<td>
						<input id='slika' type='file' name='slika' {$slika.box}>
						<input type='hidden' name='slika' value='{$carPict}'/>
						<span class='reg'>{$slika.greska}</span>
					</td>
				</tr>
			</table>
			<p>
				<input id='edit' type='submit' name='edit' value='Uredi'/>
			</p>
		</form>
	</div>
{include file="_footer.tpl"}