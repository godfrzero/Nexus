<?php 

$location = '/';

$server = 'localhost';
$u = 'redat675_code';
$p = 'we<3rocks^_^';
$db = 'redat675_nexus';
$con = mysqli_connect($server, $u, $p, $db);

$postForm = "<form id='newPost'><input id='postTitle' name='postTitle' type='text' value='' data-hint='Post Title' /><textarea id='postContent' name='postContent'></textarea> <br /><input type='button' id='closePosting' value='Cancel' /><input type='submit' value='Post It' /></form>";


function isValidEmail($email) {
	return filter_var( $email, FILTER_VALIDATE_EMAIL );
}

function isValidPassword($password) {
	return (strlen($password) >= 8);
}

function getID($username) {
	$query = 'SELECT ID FROM batteries WHERE Username="' . $username . '"';
	$IDs = mysqli_query($GLOBALS['con'], $query);
	while($row = mysqli_fetch_assoc($IDs)) {
		$ID[] = $row['ID'];
	}

	if(sizeof($ID)) {
		return $ID[0];
	} else {
		return false;
	}
}

function getFollowedPosts($PubID = "") {
	if(!$PubID) {
		$PubID = $_SESSION['ID'];
	}
	// $query = 'SELECT Following FROM batteries WHERE PubID="'.$PubID.'"';
	// $posts = mysqli_query($GLOBALS['con'], $query);
	$following = mysqli_fetch_assoc(getFollowing());
	$following = explode(',', $following['Following']);


	$query = 'SELECT * FROM posts WHERE ';
	foreach($following as $person) {
		$query .= 'Owner = "' . $person . '" OR ';
	}
	$query = substr($query, 0, strlen($query) - 4);
	$query .= 'ORDER BY Time DESC';
	return mysqli_query($GLOBALS['con'], $query);
}

function getOwnPosts($PubID = "") {
	if(!$PubID) {
		$PubID = $_SESSION['ID'];
	}
	$query = 'SELECT * FROM posts WHERE Owner="' . $PubID . '" ORDER BY Time DESC';
	return mysqli_query($GLOBALS['con'], $query);
}

function insertPost($title, $content, $owner, $name) {
	$query = "INSERT INTO posts (Title, Content, Owner, OwnerName) VALUES ('" . $title . "', '" . $content . "', '" . $owner . "', '" . $name . "')";
	$result = mysqli_query($GLOBALS['con'], $query);
	return $result;
}

function parseMessages($posts) {
	if(mysqli_num_rows($posts)) {
		$pillar[0] = ''; 
		$pillar[1] = ''; 
		$pillar[2] = '';
		$index = 0;
		ob_start();
		while($post = mysqli_fetch_assoc($posts)) {
			$pillar[$index++ % 3] .= "<div class='message'><h2>" . stripslashes($post["Title"]) . "</h2><p>" . stripslashes($post["Content"]) . "</p><div class='postDetails'>" . $post["OwnerName"] . " @ " . $post['Time'] . "</div></div>";
		}
		foreach($pillar as $column) {
			echo "<div class='messagePillar'>" . $column . "</div>";
		}
		$messages = ob_get_clean();
	} else {
		// Add a note saying they should follow someone
		$messages = "<div class='centered spaced'><h2>There are no messages to display yet :(</h2></div>";
	}
	return $messages;
}

function getUsers($PubID = "") {
	if(!$PubID) {
		$PubID = $_SESSION['ID'];
	}
	$query = "SELECT * FROM batteries WHERE PubID<>'" . $PubID . "'";
	$allUsers = mysqli_query($GLOBALS['con'], $query);
	return $allUsers;
}

function getFollowing($PubID = "") {
	if(!$PubID) {
		$PubID = $_SESSION['ID'];
	}
	$query = 'SELECT Following FROM batteries WHERE PubID="'.$PubID.'"';
	$following = mysqli_query($GLOBALS['con'], $query);
	return $following;
}

function parseUsers($users) {
	if(mysqli_num_rows($users)) {
		$pillar[0] = ''; 
		$pillar[1] = ''; 
		$pillar[2] = '';
		$jsList = array();
		$index = 0;
		ob_start();
		while($user = mysqli_fetch_assoc($users)) {
			if($user['Name'] && $user['Password']) {
				$pillar[$index++ % 3] .= "<div class='message'><h2>" . $user["Name"] . "</h2><p>" . $user['Username'] . "</p><p class='followStatus' id='" . $user["PubID"] . "'>Click to follow</p></div>";
			}
		}
		foreach($pillar as $column) {
			echo "<div class='messagePillar'>" . $column . "</div>";
		}
		$users = ob_get_clean();
	} else {
		// Add a note saying they should follow someone
		$users = "<div class='centered spaced'><h2>You're the only user! You Are Legend.</h2></div>";
	}
	return $users;
}

function parseFollowing($PubID = "") {
	if(!$PubID) {
		$PubID = $_SESSION['ID'];
	}
	$followingObject = getFollowing($PubID);
	$followingIDs = mysqli_fetch_assoc($followingObject);
	$followingIDs = explode(',', $followingIDs['Following']);

	$jsArray = '["' . implode('", "', $followingIDs) . '"]';
	return $jsArray;
}

?>