<?php
include("../inc/config.php");
include("../inc/functions.php");
global $mainDB;
$mainDB->autocommit(false);

$newProfileData = array();
$newProfileData["newProfile"]["name"] = $_POST["newProfileName"];
$newProfileData["newProfile"]["baseURL"] = $_POST["newProfileBaseURL"];
$newProfileData["newProfile"]["width"] = $_POST["newProfileWidth"];

$createProfileSQL = "INSERT INTO profile (name, baseURL, width) VALUES (?, ?, ?);";

$createProfileStatement = $mainDB->prepare($createProfileSQL);
if(!$createProfileStatement) handleDBError();
$createProfileStatement->bind_param("sss", $_POST["newProfileName"], $_POST["newProfileBaseURL"], $_POST["newProfileWidth"]);
$createProfileStatement->execute();
$createProfileStatement->close();

$newProfileIdQuery = $mainDB->query("SELECT LAST_INSERT_ID() as id");
$newProfileIdResult = $newProfileIdQuery->fetch_assoc();
$newProfileData["newProfile"]["id"] = $newProfileIdResult["id"];

$mainDB->commit();
$mainDB->close();

header("Content-type: application/x-json");
echo json_encode($newProfileData);

?>