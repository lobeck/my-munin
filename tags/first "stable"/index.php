<?php

mysql_connect("localhost", "root", "");
mysql_select_db("mymunin");

//$profile = htmlspecialchars($_GET["profile"]); not yet implemented
$baseurl = "<enter url here (http://example.com/munin/)>";
$urlseparator = "/";
$graphseparator = "-";
$graphextension = ".png";

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
		echo "					<td>" . $graph["service_title"] . " per ". $graph["graphtype"] . " on " . $graph["server"] . " (" . $graph["category"] . ")</td>\n";
		echo "				</tr>\n";
		echo "				<tr>\n";
		echo "					<td><img src=\"". $baseurl . $graph["category"] . $urlseparator . $graph["server"] . $graphseparator . $graph["service"] . $graphseparator . $graph["graphtype"] . $graphextension . "\"></td>\n";
		echo "				</tr>\n";
		echo "			</table>\n";
		echo "		</td>\n";
	}
	echo "	</tr>\n";
}
echo "</table>\n";
?>