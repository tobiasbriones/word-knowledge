<!--
  -- Copyright (c) 2015 Tobias Briones
  -- All rights reserved.
  --
  -- This source code is licensed under the BSD 3-Clause license found in the
  -- LICENSE file in the root directory of this source tree.
  -->

<?php
require "backend/src/databases/UsersDB.php";
require "backend/src/object/User.php";
require "backend/src/UserManager.php";

$userName = null;
$userScore = -1;
$userSGCPoints = -1;
$userNM = -1;

try {
  $userId = UserManager::retriveUserId();
  
  if ($userId != UserManager::NO_USER) {
    $conn = UsersDB::newInstance();
    
    $query = "
      SELECT R.user, UD.score, UD.sgc_points, UD.new_messages
      FROM register R
        INNER JOIN user_data UD
        ON R.user_id = UD.user_id
      WHERE R.user_id = '$userId'
    ";
    $result = $conn->query($query);
    $rows = $result->fetchAll();
    
    if (count($rows) == 1) {
      $userRow = $rows[0];
      $userName = $userRow["user"];
      $userScore = $userRow["score"];
      $userSGCPoints = $userRow["sgc_points"];
      $userNM = count(json_decode($userRow["new_messages"], true));
    }
    $conn = null;
  }
}
catch (PDOException $e) {
  echo "<p><strong>Failed to connect $e</strong></p>";
  exit();
}
?>

<!doctype html>
<html lang="en">
  
  <head>
    <title>Word Knowledge</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" type="text/css" href="libs/materialize/css/materialize.min.css" media="screen, projection">
    <link rel="stylesheet" type="text/css" href="css/default.css">
    <link rel="stylesheet" type="text/css" href="css/toolbar.css">
    <link rel="stylesheet" type="text/css" href="css/categories.css">
    <link rel="stylesheet" type="text/css" href="css/index/index.css">
    <link rel="stylesheet" type="text/css" href="css/index/aside.css">
    <link rel="stylesheet" type="text/css" href="css/index/msg-panel.css">
    <link rel="stylesheet" type="text/css" href="css/index/wk.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
  </head>
  
  <body>
    
    <header>
      <nav id="toolbar" class="nav-wrapper grey darken-4">
        <!-- --------------------------  TOOLBAR  -------------------------- -->
        <div>
          <div class="logo-icon"></div>
          <a class="brand-logo hide-on-small-only"></a>
          
          <ul class="right">
            <?php
            if ($userName != null) {
              ?>
              <li>
                <a href="user.php"><?php echo $userName; ?></a>
              </li>
              
              <li>
                <a href="backend/process/close_session.php">Exit</a>
              </li>
              <?php
            }
            else {
              ?>
              <li><a href="login.php">Login</a></li>
              <li><a href="register.php">Register</a></li>
              <?php
            }
            ?>
          </ul>
        
        </div>
        
        <!-- -----------------------  TOOLBAR MENU  ------------------------ -->
        <div class="toolbar-menu">
          <ul>
            <li id="mi-main" class="menu-item"><a>Main</a></li>
          </ul>
          
          <ul>
            <li id="mi-wk" class="menu-item"><a>WordKnowledge</a></li>
          </ul>
        </div>
      </nav>
    </header>
    
    
    <!-- ---------------------------  CONTAINER  --------------------------- -->
    <?php
    echo "<div id='container'
                class='container'
                data-user='$userName'
                data-score='$userScore'
                data-sgc='$userSGCPoints'
                data-nm='$userNM'>
          </div>";
    ?>
    
    <footer>
      <div>
        <p>
          Word Knowledge <a href="https://github.com/TobiasBriones/word-knowledge">GitHub</a>
        </p>
        <p>
          <i>
            © 2015 Tobias Briones
          </i>
        </p>
      </div>
    </footer>
    
    <div id="cookies-msg">
      <p>
        This site stores cookies in order to provide you with the functionality.
      </p>
      <span>X</span>
    </div>
    
    <!-- -------------------------  MESSAGE PANEL  ------------------------- -->
    <div id="msg-panel" class="card-panel z-depth-3">
      <nav id="msg_toolbar" class="nav-wrapper white">
        <div>
          <div class="logo-icon">
            <a id="msg_action_close" class="center">
              <i class="material-icons center">close</i>
            </a>
          </div>
          <a class="brand-logo hide-on-small-only">Messages</a>
        </div>
      </nav>
      
      <div id="msg_panel_container">
        <div class="conversation-panel"></div>
        <div class="separator"></div>
        <div class="senders-list"></div>
      </div>
      
      <div class="row input-msg">
        <div class="input-field col s12">
          <input id="msg_field" class="inverse-text" type="text" />
          <label for="msg_field">Message</label>
        </div>
      </div>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script>
      window.jQuery || document.write('<script src="libs/jquery-dist-2.1.4/jquery.min.js"><\/script>');
    </script>
    <script src="libs/materialize/js/materialize.min.js"></script>
    <script src="libs/js-cookie-2.0.3/js.cookie-2.0.3.min.js"></script>
    <script src="js/index.js"></script>
  
  </body>

</html>
