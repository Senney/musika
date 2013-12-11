<?php

require_once "../database/database.php";

class OwnershipWorker {
	
	private $uid;

	function __construct($userid) {
		$this->uid = $userid;
	}

	function addSong($songid, $media) {
		$query = "INSERT INTO songownership VALUES(?, ?, NULL)";
		$params = array($this->uid, $songid);
		print_r($params);
		$link = get_mysqli_link();
		mysqli_prepared_query($link, $query, "dd", $params);
		if (mysqli_error($link)) die(mysqli_error($link));
	}
}

?>
