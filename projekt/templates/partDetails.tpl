{include file="_header.tpl"}

<div id = 'sadrzaj'> 
	<div id = "part">
		<ul>	
			<br/>
			{section name=i loop=$part}
				{if (!empty($part[i].path_thumb))}
					<div class = 'imageGallery'><a href = '{$part[i].path_slika}' class = "lightbox_trigger"><img src = '{$part[i].path_thumb}' width="200" height="120" alt = 'slika'/></a></div>
				{/if}
			{/section}
			<div>
			<li>Naziv:
				<ul>
					<li>
						{section name=i loop=$part}
							{if (isset($part[i].naziv))}{$part[i].naziv}{/if}
						{/section}
					</li>
				</ul>
			</li>
			</div>
			<div id = "partBody">
			<li>Dio za:
				<ul>
					<li>
						{section name=i loop=$dioZa} 
							{if (isset($dioZa[i].naziv))}{$dioZa[i].naziv}{/if}
						{/section}
					</li>
				</ul>
				<ul>
					<li>
						{section name=i loop=$dioZa} 
							{if (isset($dioZa[i].model))}{$dioZa[i].model}{/if}
						{/section}
					</li>
				</ul>
			</li>
			<li>Opis:
				<ul>
					
					<li>
						{section name=i loop=$part}
							{if (isset($part[i].opis))}{$part[i].opis}{/if}
						{/section}
					</li>
					
				</ul>
			</li>
			<li>Cijena{if ($car[i].akcija != 0)} AKCIJA {/if}:
				<ul>
					<li> 
						{section name=i loop=$part}
							{if (isset($part[i].cijena))}{$part[i].cijena}{/if} kn {if ($part[i].akcija != 0)}(-{$part[i].akcija}%){/if}
							{if ($part[i].akcija != 0)}{$akcija}{/if}
						{/section}
					</li>
				</ul>
			</li>
			{section name=i loop=$part}			
			<form enctype='multipart/form-data' action='addToCart.php?id={$part[i].iddio}' method='post'>
				<input type='hidden' name='naziv' value='{$part[i].naziv}'/>
				<input type='hidden' name='opis' value='{$part[i].opis}'/>
				<input type='hidden' name='cijena' value='{$part[i].cijena}'/>
				<input type='hidden' name='backURL' value='2'/>
				<input id='add' type='submit' name='add' value='Dodaj'/> {$addedToCart}
			</form>
			{/section}
			<li>Ocjena:
					<ul>
					<li>
						<select name = "partRate" id = "partRate">
							<option>1</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
							<option>5</option>
						</select>
					
							<button type = "button" id = "ratePartButton" >Ocijeni!</button>
							<button type = "button" id = "getPartVotersNames" >Pogledaj ocjene!</button>
							
					</li>
					{if (isset($prosjek))}
						<li>Prosjek:
							{$prosjek}
						</li>
					{/if}
					</ul>
				</li>
				<li>
				
				</li>
			</div>
			<div id = "userRate">
			</div>
			<div id = "commentAnPart">
			<span >Komentiraj: </span><br/>
			<textarea id = "partCommentText" cols="40" rows = "4"></textarea><br/>
			<button type = "button" id = "postPartCommentButton" class = "ratePartButton">Komentiraj</button>
			</div>
			<div id = "userComments">
			</div>
		</ul>
	</div>	
</div>

{include file="_footer.tpl"}