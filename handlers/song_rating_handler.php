<?php
require_once "../common/common.php";
require_once "../database/database.php";
require_once "../workers/user_worker.php";
require_once "../workers/song_rating_worker.php";

if(!keys_exist($_GET, array("songid","rating"))) {
	header("Location:../index.php?error=0");
	exit(1);
}

$rating_worker = new SongRatingWorker();
$user_id = usrid();
$song_id = $_GET["songid"];
$rating = $_GET["rating"];


$myrating = $rating_worker->getRating($user_id,$song_id);
if(!$myrating){
	$rating_worker->addRating($user_id,$song_id,$rating);		
}
else{
	$rating_worker->updateRating($user_id,$song_id,$rating);
}

die(json_encode(array("rating" => $rating)));

?>