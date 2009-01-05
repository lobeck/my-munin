<?php

mysql_connect("localhost", "mymunin", "");
mysql_select_db("mymunin");

$profile = 1; //just for debugging
$urlseparator = "/";
$graphseparator = "-";
$graphextension = ".png";

$profileSQL = "SELECT id, name FROM profile ORDER BY id;";
$profileQuery = mysql_query($profileSQL);

echo "<select>";
while ($singleProfile = mysql_fetch_assoc($profileQuery))
{
echo "<option value=\"". $singleProfile["id"] ."\">". $singleProfile["name"] . "</option>";
}
echo "</select>";

$sql = "select * from v_collect;";

$result = mysql_query($sql);


while($dbrow = mysql_fetch_assoc($result))
{
	$data[$dbrow["row"]][$dbrow["column"]] = $dbrow;
	
}
echo "<table>\n";
foreach ($data as $row)
{
	echo "	<tr>\n";
	foreach ($row as $graph)
	{
		echo "		<td>\n";
		echo "			<table>\n";
		echo "				<tr>\n";
		echo "					<td>" . $graph["service_title"] . " per ". $graph["graphtype"] . " on " . $graph["host"] . " (" . $graph["domain"] . ")</td>\n";
		echo "				</tr>\n";
		echo "				<tr>\n";
		echo "					<td><img src=\"". $baseurl . $graph["domain"] . $urlseparator . $graph["host"] . $graphseparator . $graph["service"] . $graphseparator . $graph["graphtype"] . $graphextension . "\"></td>\n";
		echo "				</tr>\n";
		echo "			</table>\n";
		echo "		</td>\n";
	}
	echo "	</tr>\n";
}
echo "</table>\n";
?>