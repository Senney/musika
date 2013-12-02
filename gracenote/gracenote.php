<?php
include_once("../php-gracenote/Gracenote.class.php");
include_once("../database/database.php");

$clientID  = "9595136-CDC6FD136B4193F856BA76A6F2773EFC"; // Put your Client ID here.
$clientTag = "CDC6FD136B4193F856BA76A6F2773EFC"; // Put your Client Tag here.

function get_db_id() {
	$query = "SELECT userId FROM gracenote";
	$result = mysqli_prepared_query(get_mysqli_link(), $query);
	$userId = $result[0]["userId"];
	return $userId;
}

function store_db_id($userId) {
	$link = get_mysqli_link();
	$query = "INSERT INTO gracenote VALUES(?)";
	$params = array($userId);
	mysqli_prepared_query($link, $query, "s", $params);
}

function get_gracenote_userid() {
	global $clientID;
	global $clientTag;
	
	$userID = get_db_id();
	if (!isset($userID) || $userID == "") {
		echo "Getting new GN ID";
		$api = new Gracenote\WebAPI\GracenoteWebAPI($clientID, $clientTag);
		$userID = $api->register();
		
		echo "Storing Gracenote API id.";
		/** Store the Gracenote API User ID here. **/
		store_db_id($userID);
	}
	return $userID;
}

function get_gracenote_api() {
	global $clientID;
	global $clientTag;
	
	$api = new Gracenote\WebAPI\GracenoteWebAPI($clientID, $clientTag, get_gracenote_userid());
	return $api;
}

?>
