<?php
require 'core.php';
session_start();
if(isset($_SESSION['Key']) && isset($_SESSION['User'])) {
	if(isset($_POST['postContent']) || isset($_POST['postTitle'])) {

		// Escape the input so evil people don't take over the world
		$title = mysqli_real_escape_string($con, $_POST['postTitle']);
		$content = mysqli_real_escape_string($con, $_POST['postContent']);

		$id = $_SESSION['ID'];
		$name = $_SESSION['Name'];

		// Insert!
		if($id) {
			// $query = 'INSERT INTO posts (Title, Content, Owner, OwnerName) VALUES ("' . $title . '", "' . $content . '", "' . $id . '", "' . $name . '")';
			// $inserted = mysqli_query($GLOBALS['con'], $query);

			if(insertPost($title, $content, $id, $name)) {
				echo '{ Status: "Success", Reason: "Posted!" }';
			} else {
				echo '{ Status: "Failure", Reason: "Posting Failed :(" }';
			}
		}
	} else {
		echo '{ Status: "Failure", Reason: "Post must include content or title" }';
	}
} else {
	// echo '{ Status: "Failure", Reason: "Session Error", Redirect: "'.$location.'"}';
	echo '{ Status: "Failure", Reason: "Session Error"}';
}

?>