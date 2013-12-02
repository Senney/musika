<?php

require_once "../libs/password_compat/lib/password.php";
require_once "../database/database.php";

class UserWorker {
	public function getById($id) {
		$query = "SELECT * FROM users WHERE UserId = ?";
		$params = array($id);
		$result = mysqli_prepared_query(get_mysqli_link(), $query, 
			"d", $params);
		if (!$result) {
			return -1;
		}
		return $result;
	}
	
	public function getByName($name) {
		$query = "SELECT * FROM users WHERE username = ?";
		$params = array($name);
		$result = mysqli_prepared_query(get_mysqli_link(), $query, 
			"s", $params);
		if (!$result) {
			return -1;
		}	
		return $result;	
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
		if (count($result) == 0) {
			return -1;
		}
		
		$verify = password_verify($password, $result["password"]);
		if ($verify) return 0;
		else return -2;
	}
	
	public function registerUser($username, $password, $email) {
		if ($this->getByName($username) != -1) {
			return -1;
		}
		
		$link = get_mysqli_link();
		$query = "INSERT INTO users VALUES(DEFAULT, ?, ?, ?)";
		$hash = password_hash($password, PASSWORD_DEFAULT);
		$params = array($username, $hash, $email);
		$result = mysqli_prepared_query($link, $query, "sss", $params);
		return 0;		
	}
}


?>
