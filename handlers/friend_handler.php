<?php
require_once "../database/database.php";
require_once "../workers/friend_worker.php";
require_once "../workers/user_worker.php";


if (!keys_exist($_GET, array(
		"userid"
	))) {
	header("Location: ../index.php?error=0");
	exit(1);
}


$friend_worker = new FriendWorker();
$user_friend = $_GET["userid"];

$friend_worker->addFriend($user_friend);

?>