{include file="_header.tpl"}
	<div id="sadrzaj">
		<!--
		<table id='popis' border="1"> <tr><td><b>Naziv</b></td> <td><b> Opis </b> </td> <td> <b> Cijena </b></td> {if ($tip) == 3} <td> </td> {/if}</tr>
			{section name=i loop=$parts}
				<tr>
					<td>{$parts[i].naziv}</td>
					<td>{$parts[i].opis}</td> 
					<td>{$parts[i].cijena}</td>
					<td> <img src="{$users[i].path_thumb}" height='40' width='40' > </td>
					{if ($tip) == 3}
						<td> <a href="editPart.php?editID={$parts[i].iddio}" > Uredi </td>
					{/if}
				</tr>
			{/section}
		</table>

		{if $nrPages > 2}			
			{if $page > 1}
			    <a href="?page=1">&lt;&lt;</a>		
			    <a href="?page={$page-1}">&lt;</a>
			{/if}
			{section name=p start=$first loop=$last step=1}
			    {if $smarty.section.p.index==$page}
					<span>{$smarty.section.p.index}</span>
			    {else}
					<a href="?page={$smarty.section.p.index}">{$smarty.section.p.index}</a>
			    {/if}
			{/section}
			{if $page < $nrPages-1}			
			    <a href="?page={$page+1}">&gt;</a>
			    <a href="?page={$nrPages-1}">&gt;&gt;</a>	
			{/if}
	    {/if}	
		//-->
		
		<div id="pagingParts">
		</div>
	</div>
{include file="_footer.tpl"}