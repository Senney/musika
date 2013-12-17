<?php

require_once __DIR__ . "/../libs/password_compat/lib/password.php";
require_once __DIR__ . "/../database/database.php";

class UserWorker {
	public function getById($id) {
		$query = "SELECT * FROM users WHERE UserId = ?";
		$params = array($id);
		$result = mysqli_prepared_query(get_mysqli_link(), $query, 
			"d", $params);
		if (empty($result)) {
			return -1;
		}
		return $result[0];
	}
	
	public function getByName($name) {
		$query = "SELECT * FROM users WHERE username = ?";
		$params = array($name);
		$result = mysqli_prepared_query(get_mysqli_link(), $query, 
			"s", $params);
		if (empty($result)) {
			return -1;
		}	
		return $result[0];
	}
	
	public function setupSession($name) {
		$user = $this->getByName($name);
		if (empty($user)) {
			return -1;
		}
		
		// Only really need these two variables.
		if (!session_start()) {
			printf("ERROR: Unable to start the session.");
			die(1);
		}
		
		$_SESSION["user.id"] = $user["UserId"];
		$_SESSION["user.name"] = $user["username"];
	}
	public function setBio($userid, $bio){
		$link =get_mysqli_link();
		$query = "UPDATE users SET bio = ? " .
		"WHERE users.UserId = ?";
		$result = mysqli_prepared_query($link, $query,"sd",array($bio,$userid));
		
		
	
	}
	
	/**
	 * Verifies the login of a single user and password.
	 * Arguments:
	 * 	$username - The username.
	 *  $password - The password.
	 * Returns:
	 * 	0 on success.
	 *  -1 if the user does not exist.
	 *  -2 if the password does not match.
	 * Assumptions:
	 * 	$username and $password are defined.
	 **/
	public function checkLogin($username, $password) {
		$link = get_mysqli_link();
		$query = "SELECT password FROM users WHERE username=?";
		$params = array($username);
		$result = mysqli_prepared_query($link, $query, "s", $params);
		if (mysqli_error($link) || count($result) == 0) {
			return -1;
		}

		$hashpass = $result[0]["password"];
		$verify = password_verify($password, $hashpass);
		if ($verify) return 0;
		else return -2;
	}
	
	public function registerUser($username, $password, $email) {
		if ($this->getByName($username) != -1) {
			return -1;
		}
		
		$link = get_mysqli_link();
		$query = "INSERT INTO users VALUES(DEFAULT, ?, ?, ?, '')";
		$hash = password_hash($password, PASSWORD_DEFAULT);
		echo $hash;
		$params = array($username, $hash, $email);
		$result = mysqli_prepared_query($link, $query, "sss", $params);
		if (mysqli_error($link)) {
			printf("Error: %s\n", mysqli_error($link));
			die(1);
		}

		return 0;		
	}
}


?>
