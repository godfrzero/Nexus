<?php
require 'controllers/core.php';
session_start();

if(isset($_SESSION['User'])) {
	$query = 'UPDATE batteries SET SessionID="" WHERE Username="' . $_SESSION['User'] . '"';
	$cleared = mysqli_query($con, $query);
}

$_SESSION = array();
session_destroy();

header('Location: ' . $location);

?>