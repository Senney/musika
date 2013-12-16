<?
require_once "../database/database.php"

class FriendWorker{
		public function addFriend($userid){
			$link = get_mysqli_link();
			$query = "INSERT INTO friend Values(?,?)";
			$result = mysqli_prepared_query($link,$query,"dd",array(usrid(),$userid);
		
		}


}