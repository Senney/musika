<?php
require_once "../database/database.php";
require_once "../workers/friend_worker.php";
require_once "../workers/user_worker.php";

// www.senney.net/musika/handlers/friend_handler.php?userid=1&type=2
if (!keys_exist($_GET, array(
		"userid","type"
	))) {
	header("Location: ../index.php?error=0");
	exit(1);
}


$friend_worker = new FriendWorker();
$user_friend = $_GET["userid"];
$type = $_GET["type"];
if($type = 1){
$friend_worker->addFriend($user_friend);
}
elseif($type = 2){
$friend_worker->deleteFriend($user_friend);
}

?>