{include file="_header.tpl"}

<div id = 'sadrzaj'> 
		{section name=i loop=$car}
			<div id = "car">
				<ul>	
					<br/>
					{if (!empty($car[i].path_thumb))}
						<div class = 'imageGallery'><a href = '{$car[i].path_slika}' class = "lightbox_trigger"><img src = '{$car[i].path_thumb}' width="200" height="120" alt = 'slika'/></a></div>
					{/if}
					<div>
						<li>Proizvođač:
							<ul>
								<li>
									{if (isset($car[i].naziv))}{$car[i].naziv}{/if}
								</li>
							</ul>
						</li>
						</div>
						<div id = "carBody">
						<li>Model:
							<ul>
								<li>
									{if (isset($car[i].model))}{$car[i].model}{/if}
								</li>
							</ul>
						</li>
						<li>Cijena{if ($car[i].akcija != 0)} AKCIJA {/if}:
							<ul>
								<li> 
									{if (isset($car[i].cijena))}{$car[i].cijena}{/if} kn {if ($car[i].akcija != 0)}(-{$car[i].akcija}%){/if}
									{if ($car[i].akcija != 0)}{$akcija}{/if}
								</li>
							</ul>
						</li>
					<form enctype='multipart/form-data' action='addToCart.php?id={$car[i].idautomobil}' method='post'>
						<input type='hidden' name='naziv' value='{$car[i].naziv}'/>
						<input type='hidden' name='model' value='{$car[i].model}'/>
						<input type='hidden' name='cijena' value='{$car[i].cijena}'/>
						<input type='hidden' name='backURL' value='1'/>
						<input id='add' type='submit' name='add' value='Dodaj'/> {$addedToCart}
					</form>
					<li>Ocjena:
							<ul>
							<li>
								<select name = "carRate" id = "carRate">
									<option>1</option>
									<option>2</option>
									<option>3</option>
									<option>4</option>
									<option>5</option>
								</select>
							
									<button type = "button" id = "rateCarButton" >Ocijeni!</button>
									<button type = "button" id = "getCarVotersNames" >Pogledaj ocjene!</button>
									
							</li>
							{if (isset($prosjek))}
								<li>Prosjek:
									{$prosjek}
								</li>
							{/if}
							</ul>
						</li>
					</div>
					<div id = "userRate">
					</div>
					<div id = "commentAnCar">
					<span >Komentiraj: </span><br/>
					<textarea id = "carCommentText" cols="40" rows = "4"></textarea><br/>
					<button type = "button" id = "postCarCommentButton" class = "rateCarButton">Komentiraj</button>
					</div>
					<div id = "userComments">
					</div>
				</ul>
			</div>
		{/section}
		
	
</div>

{include file="_footer.tpl"}