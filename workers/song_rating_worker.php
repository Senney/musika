<?
require_once __DIR__ . "/../database/database.php";
	class SongRatingWorker{
		public function updateRating($userid,$songid,$rating){
			$link = get_mysqli_link();
			$query = "UPDATE songrating " .
			"SET rating = ? WHERE songrating.songId = ? AND songrating.userId = ?";
			$result = mysqli_prepared_query($link,$query,"ddd",array($rating,$songid,$userid));
			if (mysqli_error($link)) die(mysqli_error($link));
		}
		
		public function addRating($userid,$songid,$rating){
			$link = get_mysqli_link();
			$query = "INSERT INTO songrating Values(?,?,?)";
			$result = mysqli_prepared_query($link,$query,"ddd",array($userid,$songid,$rating));
	
		}
	
		public function getRating($userid, $songid){
			$link = get_mysqli_link();
			$query = "SELECT * FROM songrating WHERE songrating.userId = ? ".
			"AND songrating.songId =?";
			$result = mysqli_prepared_query($link, $query,"dd",array($userid, $songid));
			
			if(empty($result)) return false;
			
			return $result;
	
	
		}
	
		public function getAverage($songid){
			$link = get_mysqli_link();
			$query = "SELECT AVG(rating) AS avg FROM songrating WHERE songrating.songId = ?";
			$result = mysqli_prepared_query($link,$query,"d",array($songid));
			return $result[0]["avg"];
		
		}
	
	
	}

?>