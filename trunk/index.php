<?php

mysql_connect("localhost", "mymunin", "");
mysql_select_db("mymunin");

$profile = 1; //just for debugging
$urlseparator = "/";
$graphseparator = "-";
$graphextension = ".png";
?>
<html>
<head>
	<title></title>
	<script type="text/javascript" src="js/prototype.js"></script>
	<script type="text/javascript" src="js/scriptaculous.js"></script>
	<style type="text/css">
		.graph { float: left; border: 1px dotted; padding: 2.5px; margin: 2.5px; display:block; } 
	</style>
</head>
<body>
<?php 
$profileSQL = "SELECT id, name FROM profile ORDER BY id;";
$profileQuery = mysql_query($profileSQL);

echo "<select>\n";
while ($singleProfile = mysql_fetch_assoc($profileQuery))
{
echo "	<option value=\"". $singleProfile["id"] ."\">". $singleProfile["name"] . "</option>\n";
}
echo "</select>\n\n";

$sql = "select * from v_collect;";

$result = mysql_query($sql);


echo "<div id=\"graphs\">\n";

while($graph = mysql_fetch_assoc($result))
{
	echo "<div class=\"graph\" id=\"graph_". $graph["profileID"]. ":" . $graph["nodeID"] ."\">\n";
	echo "	<table>\n";
	echo "		<tr>\n";
	echo "			<td>" . $graph["service_title"] . " per ". $graph["graphtype"] . " on " . $graph["host"] . " (" . $graph["domain"] . ")</td>\n";
	echo "		</tr>\n";
	echo "		<tr>\n";
	echo "			<td><img src=\"". $baseurl . $graph["domain"] . $urlseparator . $graph["host"] . $graphseparator . $graph["service"] . $graphseparator . $graph["graphtype"] . $graphextension . "\"></td>\n";
	echo "		</tr>\n";
	echo "	</table>\n";
	echo "</div>\n";
	
}

echo "</div>\n";

?>
<div id="add" class="graph">add a new graph</div>
<input type="submit" value="save" onClick="save();" />
<p id="serialize">none</p>
<script type="text/javascript">
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
</script>

</body>
</html>