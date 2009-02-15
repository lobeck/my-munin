<?php
function getAvailableProfiles()
{
	global $mainDB;

	$profilesSQL = "SELECT id, name FROM profile ORDER BY id";
	$profilesResult = mysql_query($profilesSQL, $mainDB);
	
	$profiles = null;
	
	for ($i = 0; $i < mysql_num_rows($profilesResult); $i++)
	{
		$currentProfile = mysql_fetch_assoc($profilesResult);
		$profiles[$i] = $currentProfile;
	}
	
	return $profiles;
}

function getProfile($id)
{
	if (!is_numeric($id)) return null;
	
	global $mainDB;
	
	$profileSQL = "select * from profile where id = ". $id;
	$profileResult = mysql_query($profileSQL, $mainDB);

	if ($profileResult != false) 
	{
		return mysql_fetch_assoc($profileResult);
	}
	else 
	{
		return null;
	}
	
}

function getGraphs($profileId)
{
	global $mainDB;
	$graphSQL = "select * from v_collect where profileID = ". $profileId;

	$graphResult = mysql_query($graphSQL, $mainDB);
	$graphs = null;
	
	for ($i = 0; $i < mysql_num_rows($graphResult); $i++)
	{
		$graph = mysql_fetch_assoc($graphResult);
		$graphs[$i] = $graph;
	}
	
	return $graphs;
	
}
?>