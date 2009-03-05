<html>
<head>
	<title>{$title}</title>
	<script type="text/javascript" src="js/prototype.js"></script>
	<script type="text/javascript" src="js/scriptaculous.js"></script>
	<script type="text/javascript" src="js/cookie.js"></script>
	<script type="text/javascript" src="js/jquery.js"></script>
	<link rel="stylesheet" href="css/main.css" type="text/css">
	<style type="text/css">
	 #graphs {literal}{{/literal} width: {$selectedProfile.width}px; {literal}}{/literal}
	 </style>
</head>
<body>
	<select>
		{foreach from=$availableProfiles item=singleProfile}
			<option value="{$singleProfile.id}"{if $selectedProfile.id eq $singleProfile.id} selected{/if}>{$singleProfile.name}</option>
		{/foreach}
	</select>
	<div>
	<form onSubmit="createProfile(); return false;" id="newProfileForm" action="ajax/createProfile.php?method=noscript" method="POST">
		<input type="text" name="newProfileName" value="profile name">
		<input type="text" name="newProfileBaseURL" value="munin url">
		<input type="text" name="newProfileWidth" value="width in px">
		<input type="submit" value="create profile">
	</form>
	</div>
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
	<div id="add" class="graph">add a new graph</div>
</div>


<input type="submit" value="save" onClick="save();" />
<p id="serialize">none</p>
<script type="text/javascript">
{literal}
	jQuery.noConflict();
	
	(function(){ 
		var info = $('serialize');
	
	  Sortable.create('graphs', {
	    tag:'div',overlap:'horizontal',constraint: false,
	    onUpdate:function(){
	       info.update("Graph order changed - please save");
	    }
	  });
	})();
	
	var graphs = $('graphs');
	var info = $('serialize');
	
	function save()
	{
		info.update("saving...");
		
		new Ajax.Request("ajax/saveOrder.php", {
			method: "post",
			parameters: { data: Sortable.serialize("graphs") },
			onSuccess: function(transport) { info.update(transport.responseText) }
		});
	}
	
	function createProfile()
	{
		info.update( "creating profile..." );
		
		new Ajax.Request("ajax/createProfile.php", {
			method: "post",
			parameters: $('newProfileForm').serialize(true),
			onSuccess: function(transport) { info.update(transport.responseText) },
			onFailure: function(transport) { info.update(transport.responseText) }
		});
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