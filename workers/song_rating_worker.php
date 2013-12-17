<?
	class SongRatingWorker{
		public function updateRating($userid,$songid,$rating){
			$link = get_mysqli_link();
			$query = "UPDATE songrating " .
			"SET rating = ? WHERE songrating.songId = ? AND songrating.userId = ?" ;
			$result = mysqli_prepared_query($link,$query,"ddd",array($rating,$songid,$userid);
		
		}
		public function addRating($userid,$songid,$rating){
			$link = get_mysqli_link();
			$query = "INSERT INTO songrating Values(?,?,?)";
			$result = mysqli_prepared_query($link,$query,"ddd",array($userid,$songid,$rating);
	
		}
	
		public function getRating($userid, $songid){
			$link = get_mysqli_link();
			$query = "SELECT * FROM songrating WHERE songrating.userId =?".
			"AND songrating.songId =?";
			$result = mysquli_prepared_query($link, $query,"dd",array($userid, $songid);
			
			if(empty($result)) return false;
			
			return $result;
	
	
		}
	
		public function getAverage($songid){
			$link = get_mysqli_link();
			$query = "SELECT AVG(rating) FROM songrating WHERE songrating.songId = ?";
			$result = mysquli_prepared_query($link,$query,"d",array($songid);
			return $result;
		
		}
	
	
	}

?>