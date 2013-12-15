<?php
require once "../common/common.php";

if (!keys_exist($_POST, array(
		"playlist-name"
	))) {
	header("Location: ../add.php?error=0");
	exit(1);
}





>