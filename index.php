<?php
/* 
	$Id$ 
  
  	my-munin - a customizeable dashboard for your munin installation (my-munin.org)
	Copyright (C) 2009 Christian Becker (christian@my-munin.org)
	
	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

mysql_connect("localhost", "mymunin", "");
mysql_select_db("mymunin");

function getSelectedProfile() {
	if (is_numeric($_COOKIE["profileID"]))
	{
		return $_COOKIE["profileID"];
	} else {
		return 1;
	}
}

$profile = getSelectedProfile();
$urlseparator = "/";
$graphseparator = "-";
$graphextension = ".png";
?>
<html>
<head>
	<title></title>
	<script type="text/javascript" src="js/prototype.js"></script>
	<script type="text/javascript" src="js/scriptaculous.js"></script>
	<script type="text/javascript" src="js/cookie.js"></script>
	<style type="text/css">
		body { font-size: 11px; }
		.graph { float: left; border: 1px dotted; padding: 2.5px; margin: 2.5px; display:block; } 
		.graph_title { cursor:move; }
	</style>
</head>
<body>
<?php 
/*
 * get all saved profiles
 */

$profilesSQL = "SELECT id, name FROM profile ORDER BY id;";
$profilesQuery = mysql_query($profilesSQL);

?>
	<select>
<?php 
	
	/*
	 * generate one <option> tag for every saved profile
	 */
	while ($singleProfile = mysql_fetch_assoc($profilesQuery)) {
?>
		<option value="<?php echo $singleProfile["id"]; ?>"<?php echo ($singleProfile["id"] == $profile ? " selected=\"selected\"" : "" ); ?>><?php echo $singleProfile["name"]; ?></option>
<?php 
	}
?>
	</select>
<?php 

$selectedProfileSQL = "select * from profile where id = ". $profile .";";
$selectedProfileQuery = mysql_query($selectedProfileSQL);

$selectedProfile = mysql_fetch_assoc($selectedProfileQuery);

$sql = "select * from v_collect where profileID = ". $profile .";";

$result = mysql_query($sql);


echo "<div id=\"graphs\">\n";

while($graph = mysql_fetch_assoc($result))
{
	echo "<div class=\"graph\" id=\"graph_". $graph["profileID"]. ":" . $graph["nodeID"] ."\">\n";
	echo "	<table>\n";
	echo "		<tr>\n";
	echo "			<td class=\"graph_title\">" . $graph["service_title"] . " per ". $graph["graphtype"] . " on " . $graph["host"] . " (" . $graph["domain"] . ")</td>\n";
	echo "		</tr>\n";
	echo "		<tr>\n";
	echo "			<td><img src=\"". $selectedProfile["baseURL"] . $graph["domain"] . $urlseparator . $graph["host"] . $graphseparator . $graph["service"] . $graphseparator . $graph["graphtype"] . $graphextension . "\"></td>\n";
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