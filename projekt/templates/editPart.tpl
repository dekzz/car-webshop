{include file="_header.tpl"}
	<div id='sadrzaj'>
		<form enctype='multipart/form-data' action='editingPart.php' method='post'>
			<table border='0'>
				<tr>
					<td><label for='naziv'>Naziv:</label></td>
					<td>
						<input id='naziv' type='text' name='naziv' {$name.box} {$imeZauzeto.box} value='{$partName}{$name.vrijednost}'/> 
						<span class='reg'>
							{$name.greska}
							{$imeZauzeto.greska}
						</span>
					</td>
				</tr>
				<tr>
					<td><label for='opis'>Opis:</label></td>
					<td>
						<input id='opis' type='text' name='opis' {$desc.box} value='{$partDesc}{$desc.vrijednost}'/> 
						<span class='reg'>{$desc.greska}</span>
					</td>
				</tr>
				<tr>
					<td><label for='cijena'>Cijena:</label></td>
					<td>
						<input id='cijena' type='text' name='cijena' {$price.box} value='{$partPrice}{$price.vrijednost}'/> 
						<span class='reg'>{$price.greska}</span>
					</td>
				</tr>
				<tr>
					<td><label for='akcija'>Akcija:</label></td>
					<td>
						<input id='akcija' type='text' name='akcija' {$akcija.box} value='{$partAction}'/> 
						<span id='ajaxResponse' class='greska'>{$akcija.greska}</span>
					</td>
				</tr>
				<tr>
					<td><label for='slika'>Slika:</label></td>
					<td>
						<input id='slika' type='file' name='slika' {$slika.box}>
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