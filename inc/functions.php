<?php
function getAvailableProfiles()
{
	global $mainDB;

	$profilesQuery = $mainDB->query("SELECT id, name FROM profile ORDER BY id");
	$profiles = null;
	
	for ($i = 0; $i < $profilesQuery->num_rows; $i++)
	{
		$currentProfile = $profilesQuery->fetch_assoc();
		$profiles[$i] = $currentProfile;
	}
	
	return $profiles;
}

function getProfile($id)
{
	if (!is_numeric($id)) return null;
	
	global $mainDB;
	
	$profileQuery = $mainDB->query("select * from profile where id = ". $id);
	
	if ($profileQuery !== false) 
	{
		return $profileQuery->fetch_assoc();
	}
	else 
	{
		return null;
	}
	
}

function getGraphs($profileId)
{
	global $mainDB;
	$graphQuery = $mainDB->query("select * from v_collect where profileID = ". $profileId);

	$graphs = null;
	
	for ($i = 0; $i < $graphQuery->num_rows; $i++)
	{
		$graph = $graphQuery->fetch_assoc();
		$graphs[$i] = $graph;
	}
	
	return $graphs;
	
}
?>