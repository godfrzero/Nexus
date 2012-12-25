<?php require_once '../controllers/core.php'; ?>
<?php 
  session_start(); 
  if(!isset($_SESSION['User'])) {
    header('Location: ' . $location);
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>mix // redefine social</title>
  <link rel="stylesheet" type="text/css" href="../resources/css/splash.css?<?= hash_file('crc32', '../resources/css/splash.css') ?>">
  <script src="../resources/js/jquery-1.8.2.min.js?<?= hash_file('crc32', '../resources/js/jquery-1.8.2.min.js') ?>"></script>
  <script src="../resources/js/splash.js?<?= hash_file('crc32', '../resources/js/splash.js') ?>"></script>
  <?php if(isset($_SESSION['User'])) { ?>  
  <style>
    div#loginWrap {
      width: 978px;
      top: 0;
      left: 0;
      right: 0;
      bottom: auto;
      margin-top: 0;
      position: static;
    }

    div#actionWindow {
      width: 735px;
    }

    div.message {
      cursor: pointer;
    }    
  </style>
  <script>

    var following = <?= parseFollowing() ?>;

    jQuery(document).ready(function($){
      $('#messageWrapper').slideToggle().animate({opacity: 1});
      // Initialize hinting again to process new form fields
      initializeHinting();

      // Show the new contents
      $('#actionWindow li').animate({opacity: 1});

      // Highlight people who are already being followed
      if(following[1]) {
        for(personID in following) {
          // console.log(following[personID] + ' is being followed');
          if(following[personID].length) {
            var thisChild = getElement(following[personID]);
            $(thisChild).html('Click to Unfollow');
            $(thisChild.parentNode).addClass('following');
          }
        }
      }

      // Process clicks to follow or unfollow
      $('.message').click(function(){
        var $thisElement = this;
        var thisStatus = this.children[2];
        var thisID = thisStatus.id;
        // console.log($thisElement, thisStatus, thisID);

        var newFollowing = [];
        for(thisPerson in following) {
          // console.log(following[thisPerson]);
          if(!(thisID == following[thisPerson])) {
            // Clicked person and matched person aren't the same, take no action
            newFollowing.push(following[thisPerson]);
          } else {
            // It's a match! Don't move this person to the new following array
            $($thisElement).removeClass('following');
            $(thisStatus).html('Click to Follow');
          }
        }
        // Now, if the length of the newFollowing array and following array are the same
        // Then we know there were no matches, and the clicked ID is a new one
        // So we need to start following that person
        if(newFollowing.length == following.length) {
          newFollowing.push(thisID);
          $($thisElement).addClass('following');
          $(thisStatus).html('Click to Unfollow');
        }
        following = newFollowing;
        // Let see the result of this weird logic...
        // console.log(newFollowing);

        // Okay, lets make a string and send it!
        var sendString = newFollowing.join(',');
        var parameters = 'newFollow=' + sendString;
        sendRequest('POST', '/controllers/flowControl.php', parameters);
      });
    });
  </script>
  <?php } ?>
</head>
<body>
  <div id="loginWrap">
    <div id="logoContainer">
      <div class="vCenter">
        <a href="/"><img src="../resources/branding/Logo.png" height="50" width="162" id="splashLogo" /></a>
      </div>
    </div>
    <div id="actionWindow">
        <ul>
          <li>
            <div class="vCenter">
              <button id="postTrigger" value="Post Something">Post Something</button>
              <a href="../people/"><button id="peopleTrigger" value="Find People">Find People</button></a>
              <a href="../mine/"><button id="selfTrigger" value="Your Posts">Your Posts</button></a>
              <a href="../logout.php"><button id="logout" value="Logout">Logout</button></a>
            </div>
          </li>
        </ul>
    </div>
  </div>
  <div id="messageWrapper">
    <?php if(isset($_SESSION['User'])) { ?>
      <?php 
        $query = 'SELECT * FROM batteries WHERE Username="' . $_SESSION['User']. '"';
        $userDetails = mysqli_query($con, $query);
        $userDetails = mysqli_fetch_assoc($userDetails);

        if(!$userDetails['Password'] || !$userDetails['Name']) { ?>
          <div id="completeProfile">
            <p>Looks like we need some more information before people can start following you:</p>
            <form id="profileForm">
              <input type="password" id="password" name="password" data-hint="429821223" />
              <input type="password" id="passwordConfirm" name="passwordConfirm" data-hint="419221553" />
              <input type="text" id="Name" name="Name" data-hint="Nickname" />
              <input type="submit" value="Submit" />
            </form>
          </div>
        <?php 
        } else {
          $userObject = getUsers();
          $users = parseUsers($userObject);
          echo $GLOBALS['postForm'].$users;
        }
      ?>
    <?php } ?>
  </div>
</body>
</html>