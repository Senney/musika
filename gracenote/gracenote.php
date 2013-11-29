<?php
include_once("../php-gracenote/Gracenote.class.php");

$clientID  = "9595136"; // Put your Client ID here.
$clientTag = "CDC6FD136B4193F856BA76A6F2773EFC"; // Put your Client Tag here.

function get_gracenote_userid() {
	global $clientID;
	global $clientTag;
	
	$userID = "264114340339182498-A9B8E0B66E20EE19B21EF883DDFEC9A3"; /** Later: Populate this from the database. **/
	if (!isset($userID) || $userID == "") {
		$api = new Gracenote\WebAPI\GracenoteWebAPI($clientID, $clientTag);
		$userID = $api->register();
		/** Store the Gracenote API User ID here. **/
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
