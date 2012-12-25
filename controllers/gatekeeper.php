<?php
require 'core.php';

session_start();

 // This file processes login and signups, returning a 
 // Status or either Success or Failure depending on the result

if(isset($_POST['eMail']) && isset($_POST['pWord']) && isValidEmail($_POST['eMail']) && isValidPassword($_POST['pWord'])) {
	// Login code
	// Batteries = people or user, from the matrix :P
	$query = 'SELECT * FROM batteries WHERE Username="' . $_POST["eMail"] . '"';
	$res = mysqli_query($con, $query);

	while($row = mysqli_fetch_assoc($res)) {
		$AuthKey = hash('sha1', $_POST['eMail'] . $_POST['pWord'] . $row['Salt']);
		if($AuthKey == $row['Password']) {
			$sessionKey = hash('sha1', mt_rand(1111, 9999));

			$query = "UPDATE batteries SET SessionID='" . $sessionKey . "' WHERE ID='" . $row['ID'] . "'"; 
			$insertion = mysqli_query($con, $query);

			$_SESSION['Key'] = $sessionKey;
			$_SESSION['Salt'] = $row['Salt'];
			$_SESSION['User'] = $row['Username'];
			$_SESSION['ID'] = $row['PubID'];
			$_SESSION['Name'] = $row['Name'];

			// Get content to show the user, because an empty page is pretty lonely.
			$posts = getFollowedPosts();
			$messages = parseMessages($posts);

			$content = $postForm . $messages;

			if($insertion) {
				echo "{Status: 'Success', Content: " . json_encode($content) . "}";
			} else {
				echo "{Status: 'Failure', Content: 'Session Error: Please reload the page.'}";
			}

		} else {
			echo "{Status: 'Failure', Reason: 'Invalid details, Login failed.'}";
		}
	}
} else if(isset($_POST['signUpEmail'])) {
	if(isValidEmail($_POST['signUpEmail'])) {
		// Signup code 
		$query = "SELECT * FROM batteries WHERE Username='" . $_POST['signUpEmail'] . "'";
		$res = mysqli_query($con, $query);
		$row = mysqli_fetch_assoc($res);
		if(mysqli_num_rows($res)) {
			echo '{Status: "Failure", Reason: "That email is already registered!"}';
		} else {
			$salt = mt_rand(1000, 9999);

			$query = "INSERT INTO batteries (Username, Salt) VALUES ('" . $_POST['signUpEmail'] . "', '" . $salt . "')";
			$res = mysqli_query($con, $query);

			do {
				$seed = mt_rand(0, 999999);
				$pubID = hash('sha1', $seed . $_POST['signUpEmail']);

				$query = 'SELECT * FROM batteries WHERE PubID="' . $pubID . '"';
				$result = mysqli_query($con, $query);
			} while (mysqli_num_rows($result));

			$query = 'UPDATE batteries SET PubID="' . $pubID . '" WHERE Username="' . $_POST['signUpEmail'] . '"';
			$setPubID = mysqli_query($con, $query);

			if($res && $setPubID) {
				//$content = "<div id='completeProfile'><p>Looks like we need some more information before people can start following you:</p><form id='profileForm'><input type='password' id='password' name='password' data-hint='429821223' /><input type='password' id='passwordConfirm' name='passwordConfirm' data-hint='419221553' /><input type='text' id='Name' name='Name' data-hint='Nickname' /><input type='submit' value='Submit' /></form></div>";
				echo '{Status: "Success", Redirect: ' . json_encode($location) . ' }';
				$sessionKey = hash('sha1', mt_rand(1111, 9999));
				$_SESSION['Key'] = $sessionKey;
				$_SESSION['User'] = $_POST['signUpEmail'];
				$_SESSION['Salt'] = $salt;
				$_SESSION['ID'] = $pubID;
			} else {
				echo '{Status: "Failure", Reason: "Signup Failed"}';
			}
		}
	}
} else if(isset($_POST['password']) && isset($_POST['passwordConfirm']) && isset($_POST['Name'])) {
	if($_POST['password'] == $_POST['passwordConfirm'] && strlen($_POST['password']) >= 8 && preg_match('/^[a-z A-Z0-9_-]{2,20}$/', $_POST['Name'])) {
		$password = hash('sha1', $_SESSION['User'] . $_POST['password'] . $_SESSION['Salt']);
		$query = 'UPDATE batteries SET Password="' . $password . '", Name="' . $_POST['Name'] . '" WHERE PubID="' . $_SESSION['ID'] . '"';
		$updated = mysqli_query($con, $query);

		$_SESSION['Name'] = $_POST['Name'];

		if($updated) {
			echo '{Status: "Success", Redirect: ' . json_encode($location) . ' }';
		} else {
			echo "{Status: 'Failure', Reason: 'Update failed!'}";
		}
	} else {
		echo "{Status: 'Failure', Reason: 'Somethings wrong! Make sure both passwords match, and name should only have letters.'}";
	}
} else {
	// Default code, dealing with errors?
		//echo "{Status: 'Failure', Reason: 'General Failure: Unknown Command'}";
	// Testing code only, return parameters as they were received:
		$value = '';
		foreach($_POST as $field) {
			$values .= $field;
		}
		echo "{Status: 'Failure', Reason: 'A " . $values . "'}";
}
?>