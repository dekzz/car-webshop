{include file="_header.tpl"}
	<div id="sadrzaj">
		<!--
		<table id='popis' border="1"> <tr><td><b>Konfiguracija</b></td> <td><b> Automobil </b> </td> <td> <b> Dio </b></td> </tr>
			{section name=i loop=$conf}
				<tr>
					<td>{$conf[i].idkonfiguracije}</td>
					<td>{$conf[i].automobil_idautomobil}</td> 
					<td>{$conf[i].dijelovi_iddio}</td>
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
		
		<div id="pagingConfs">
		</div>
	</div>
{include file="_footer.tpl"}