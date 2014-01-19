{include file="_header.tpl"}
	<div id='sadrzaj'>
		<form id='unosKonfiguracija' enctype='multipart/form-data' action='odaberiDio.php' method='post'>
			<table border='0'>
				<tr>
					<td>
						<select name='auto'>
							<option value="N/A">Odaberite vozilo</option>
							{section name=i loop=$cars} 
								<option {if ($confCar == $cars[i].idautomobil)}selected='selected'{/if} value="{$cars[i].idautomobil}">{$cars[i].naziv} {$cars[i].model} {$cars[i].cijena}</option>
							{/section}
						</select>
						<input type='hidden' name='confID' value='{$confID}'/>
						<span id='ajaxResponse' class='greska'>
							{$automobil.greska}
						</span>
					</td>
				</tr>
			</table>
			<p>
				<input id='odaberiDio' type='submit' name='odaberiDio' value='Odabir dijelova'/>
			</p>
			{$saved}
		</form>
	</div>
{include file="_footer.tpl"}