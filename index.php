<?php require_once 'controllers/core.php'; ?>
<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>mix // redefine social</title>
  <link rel="stylesheet" type="text/css" href="resources/css/splash.css?<?= hash_file('crc32', 'resources/css/splash.css') ?>">
  <script src="resources/js/jquery-1.8.2.min.js?<?= hash_file('crc32', 'resources/js/jquery-1.8.2.min.js') ?>"></script>
  <script src="resources/js/splash.js?<?= hash_file('crc32', 'resources/js/splash.js') ?>"></script>
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
  </style>
  <script>
    jQuery(document).ready(function($){
      $('#messageWrapper').slideToggle().animate({opacity: 1});
      // Initialize hinting again to process new form fields
      initializeHinting();

      // Show the new contents
      $('#actionWindow li').animate({opacity: 1});
    });
  </script>
  <?php } ?>
</head>
<body>
  <div id="loginWrap">
    <div id="logoContainer">
      <div class="vCenter">
        <a href="/"><img src="resources/branding/Logo.png" height="50" width="162" id="splashLogo" /></a>
      </div>
    </div>
    <div id="actionWindow">
      <?php if(isset($_SESSION['User'])) { ?>  
        <ul>
          <li>
            <div class="vCenter">
              <button id="postTrigger" value="Post Something">Post Something</button>
              <a href="people/"><button id="peopleTrigger" value="Find People">Find People</button></a>
              <a href="mine/"><button id="selfTrigger" value="Your Posts">Your Posts</button></a>
              <a href="logout.php"><button id="logout" value="Logout">Logout</button></a>
            </div>
          </li>
        </ul>
      <?php } else { ?>
      <ul>
        <li id="slideTrigger">
          <div class="vCenter">
            <button class="slideTrigger" id="target_1" value="Sign Up">Sign Up</button> or 
            <button class="slideTrigger" id="target_2" value="Sign In">Sign In</button>
          </div>
        </li>
        <li>
          <form class="vCenter" id="signupForm">
            <input type="text" id="signUpEmail" name="signUpEmail" data-hint="Email" /> <br />
            <input type="button" class="slideTrigger" id="target_0" value="Back" />
            <input type="submit" value="Go!" id="signUp" />
          </form>
        </li>
        <li>
          <form class="vCenter" id="loginForm">
            <input type="text" id="eMail" name="eMail" data-hint="Email"<?= isset($_SESSION['User']) ? 'value="'.$_SESSION['User'].'"' : '' ?> /> <br />
            <input type="password" id="pWord" name="pWord" data-hint="pword" /> <br />
            <input type="button" class="slideTrigger" id="target_0" value="Back" />
            <input type="submit" value="Go!" id="logIn" />
          </form>
        </li>
      </ul>
      <?php } ?>
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
          $posts = getFollowedPosts();
          $messages = parseMessages($posts);
          echo $GLOBALS['postForm'].$messages;
        }
      ?>
    <?php } ?>
  </div>
</body>
</html>