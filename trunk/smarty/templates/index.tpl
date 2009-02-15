<html>
<head>
	<title>{$title}</title>
	<script type="text/javascript" src="js/prototype.js"></script>
	<script type="text/javascript" src="js/scriptaculous.js"></script>
	<script type="text/javascript" src="js/cookie.js"></script>
	<link rel="stylesheet" href="css/main.css" type="text/css">
	<style type="text/css">
	 #graphs {literal}{{/literal} width: {$selectedProfile.width}px; {literal}}{/literal}
	 </style>
</head>
<body>
	<select>
		{foreach from=$availableProfiles item=singleProfile}
			<option value="{$singleProfile.id}" {if $selectedProfile.id eq $singleProfile.id}selected{/if}>{$singleProfile.name}</option>
		{/foreach}
	</select>
<div id="graphs">
	{foreach from=$graphs item=graph}
	<div class="graph" id="graph_{$graph.profileID}:{$graph.nodeID}">
		<table>
			<tr>
				<td class="graph_title">{$graph.service_title} per {$graph.graphtype} on {$graph.host} ({$graph.domain})</td>
			</tr>
			<tr>
				<td><img src="{$selectedProfile.baseURL}{$graph.domain}{$config.urlseparator}{$graph.host}{$config.graphseparator}{$graph.service}{$config.graphseparator}{$graph.graphtype}{$config.graphextension}"></td>
			</tr>
		</table>
	</div>
	{/foreach}
</div>

<div id="add" class="graph">add a new graph</div>
<input type="submit" value="save" onClick="save();" />
<p id="serialize">none</p>
<script type="text/javascript">
{literal}
	(function(){ 
		var info = $('serialize');
	
	  Sortable.create('graphs', {
	    tag:'div',overlap:'horizontal',constraint: false,
	    onUpdate:function(){
	       info.update(Sortable.serialize('graphs'));
	    }
	  });
	})();
	
	var graphs = $('graphs');
	var info = $('serialize');
	
	function save()
	{
		info.update(Sortable.sequence('graphs'));
	}
	function bigger()
	{
		graphs.style.width = 2000;
	}
	function smaller()
	{
		graphs.style.width = 600;
	}
{/literal}
</script>

</body>
</html>