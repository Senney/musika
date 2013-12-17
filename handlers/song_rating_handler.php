<?php
require_once "../common/common.php";
require_once "../database/database.php";
require_once "../workers/user_worker.php";
require_once "../workers/song_rating_worker.php";


if(!key_exists($GET, array("songid","userid","rating)))
	{header("Location:../index.php?error=0");
	exit(1);
}

$rating_worker = new SongRatingWorker();
$user_id = $_GET["userid"];
$song_id = $_GET["songid"];
$rating = $GET["rating"];


$myrating = rating_worker->getRating($user_id,$song_id)
if(!$myrating){
		$rating_worker->addRating($user_id,$song_id,$rating);		
}
else{
	$rating_worker->updateRating($user_id,$song_id,$rating);
}
?>