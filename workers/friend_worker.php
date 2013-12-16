<?
require_once "../database/database.php"

class FriendWorker{
		public function addFriend($userid){
			$link = get_mysqli_link();
			$query = "INSERT INTO friend Values(?,?)";
			$result = mysqli_prepared_query($link,$query,"dd",array(usrid(),$userid);
		
		}
		public function getUserFriend($userid){
			$link = get_mysqli_link();
			$query = "SELECT * FROM friend JOIN user ON friend.FriendId  == users.UserId ".
			"WHERE friend.FriendId = ?"
			
			$result = mysqli_prepared_query($link, $query, "d",array($userid)); 
			
		
			if(empty($result)) return false;
			return $result[0];
		}
		
		public function deleteFriend($userid)
		{
		$link = get_mysqli_link();
		$query = "DELTE FROM friend WHERE friend.UserId = ? AND friend.FriendId = ?"
		$result = mysqli_prepared_query($link,$query,"dd",array(usrid(),$userid));
		
		
		
		}
		

}