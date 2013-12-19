<?php
require_once __DIR__ . "/../database/database.php";

class StatsWorker{
	public function totalNumberSongs(){
		$query = "SELECT COUNT(SID) AS TotalSongs FROM song";
		$link  = get_mysqli_link();
		$result = mysqli_prepared_query($link,$query);
		
		return $result[0] ["TotalSongs"];
	
	
	
	}
	
	public function mostPopularSongs(){
		$link  = get_mysqli_link();
		
		/** Query sourced from:
		http://stackoverflow.com/a/6744815
		Author: http://stackoverflow.com/users/630535/nabuchodonossor
		Accessed: December 17th, 2013 **/
		$query = "SELECT good.value2 AS SID, COUNT(good.value1) AS numsongs FROM".
		"(SELECT DISTINCT LEAST(so.SID, so.UID) AS value1, GREATEST(so.SID, so.UID) AS value2 FROM songownership AS so) AS good ".
		"GROUP BY good.value2 ORDER BY numsongs DESC LIMIT 10";
		$result = mysqli_prepared_query($link,$query);
		if (mysqli_error($link)) die(mysqli_error($link));
		
		return $result;
	}

	public function totalNumberArtists(){
		$query = "SELECT COUNT(artistId) AS TotalArtists FROM artist";
		$link  = get_mysqli_link();
		$result = mysqli_prepared_query($link,$query);
		
		return $result[0] ["TotalArtists"];
	
	}
	public function totalNumberAlbums(){
		$query = "SELECT COUNT(albumID) AS TotalAlbums FROM album";
		$link  = get_mysqli_link();
		$result = mysqli_prepared_query($link,$query);
		
		return $result[0] ["TotalAlbums"];
	
	
	}



}


?>