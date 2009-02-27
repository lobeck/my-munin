<?php
include("../inc/config.php");
global $mainDB;
$mainDB->autocommit(false);

$i = 1;
$data = array();

parse_str($_POST["data"], $data);

foreach ($data["graphs"] as $graph) {
	$separatorPosition = strpos($graph, ":");
	$profileId = substr($graph, 0, $separatorPosition);
	$nodeId = substr($graph, $separatorPosition+1); 
	
	if ($i == 1)
	{
		$statement = $mainDB->prepare("DELETE FROM position where profileID = ?");
		if (!$statement) handleDBError();
		
		$statement->bind_param("i", $profileId);
		$statement->execute();
		$statement->close();
		echo "deleted<br>";
		
		$statement = $mainDB->prepare("INSERT INTO position (profileID, nodeID, `order`) VALUES (?, ?, ?)");
		if (!$statement) handleDBError();
		echo "statement prepared<br>";
	}

	if ($profileId > 0 && $nodeId > 0)
	{
		$statement->bind_param("iii", $profileId, $nodeId, $i);
		
		if ($statement->execute() !== true) handleDBError();
		echo "ok<br>";
		$i++;
	}
}
$statement->close();

$mainDB->commit();
$mainDB->close();

function handleDBError()
{
	global $mainDB;
	
	echo "transaction error - ". $mainDB->error ."<br";
	$mainDB->rollback();
	$mainDB->close();
	exit; 
}

?>