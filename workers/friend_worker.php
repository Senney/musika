<?
require_once __DIR__ . "/../database/database.php";

class FriendWorker{
		public function addFriend($userid){
			$link = get_mysqli_link();
			$query = "INSERT INTO friend Values(?,?)";
			if(!(usrid() == $userid)){
			$result = mysqli_prepared_query($link,$query,"dd",array(usrid(),$userid));
			}
			else{
				return false;
			}
		}
		public function getUserFriend($userid){
			$link = get_mysqli_link();
			$query = "SELECT * FROM friend JOIN users ON friend.FriendId = users.UserId ".
			"WHERE friend.UserId = ?";
			$result = mysqli_prepared_query($link, $query, "d",array($userid)); 
			if (mysqli_error($link)) die(mysqli_error($link));
			if(empty($result)) return false;
			return $result;
		}
		
		public function deleteFriend($userid)
		{
			$link = get_mysqli_link();
			$query = "DELETE FROM friend WHERE friend.UserId = ? AND friend.FriendId = ?";
			$result = mysqli_prepared_query($link,$query,"dd",array(usrid(),$userid));
		}
		

}