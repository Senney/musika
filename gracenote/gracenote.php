<?php
include_once("../php-gracenote/Gracenote.class.php");

$clientID  = "9595136-CDC6FD136B4193F856BA76A6F2773EFC"; // Put your Client ID here.
$clientTag = "CDC6FD136B4193F856BA76A6F2773EFC"; // Put your Client Tag here.

function get_gracenote_userid() {
	$userID = ""; /** Later: Populate this from the database. **/
	if (!isset($userID) || $userID == "") {
		$api = new Gracenote\WebAPI\GracenoteWebAPI($clientID, $clientTag);
		$userID = $api->register();
		/** Store the Gracenote API User ID here. **/
	}
	return $userID;
}

function get_gracenote_api() {
	$api = new Gracenote\WebAPI\GracenoteWebAPI($clientID, $clientTag, get_gracenote_userid());
	return $api;
}

?>
