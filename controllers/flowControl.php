<?php
require 'core.php';
session_start();
if(isset($_SESSION['Key']) && isset($_SESSION['User'])) {
	if(isset($_POST['newFollow'])) {
		$PubID = $_SESSION['ID'];

		// Insert!
		if($PubID) {
			$query = 'UPDATE batteries SET Following="' . $_POST['newFollow'] . '" WHERE PubID="' . $PubID . '"';
			$inserted = mysqli_query($GLOBALS['con'], $query);

			if($inserted) {
				echo '{ Status: "Success", Reason: "Following Updated!" }';
			} else {
				echo '{ Status: "Failure", Reason: "Following Update Failed :(" }';
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