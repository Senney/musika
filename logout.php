<?php
require_once "common/common.php";

safe_session_start();
session_destroy();
header("Location: index.php");

?>
