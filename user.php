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

$user = null;
$isLocalUser = false;

try {
  $conn = UsersDB::newInstance();
  
  if (isset($_GET["user"])) {
    session_start();
    
    $user = User::findUserByName($conn, $_GET["user"]);
    $luId = UserManager::retriveUserId();
    
    if ($user == null || !$user->userExists) {
      printUDNE();
      exit();
    }
    if ($luId != UserManager::NO_USER) {
      $result = $conn->query("SELECT user FROM register WHERE user_id = '$luId'");
      $rows = $result->fetchAll();
      
      if (count($rows) != 1) {
        header("Location: login.php");
        exit();
      }
      $luUN = $rows[0]["user"];
      
      if ($luUN == $user->user) {
        $isLocalUser = true;
      }
      else {
        $isLocalUser = false;
        $_SESSION["msgs"] = 0;
        $_SESSION["rec"] = $user->id;
      }
    }
    else {
      header("Location: login.php");
      exit();
    }
  }
  else {
    $isLocalUser = true;
    $user = UserManager::retriveUser($conn);
    
    if ($user == null || !$user->userExists) {
      header("Location: login.php");
      exit();
    }
  }
}
catch (PDOException $e) {
  echo "There were problems to connect<br>";
  exit();
}
echo "<title>$user->user</title>";

function printUDNE() {
  echo "<title>User not found</title>";
  echo "User doesn't exist<br/>";
  echo "<a href='login.php'>Login</a><br/>";
  echo "<a href='register.php'>Register</a>";
}

?>

<!doctype html>
<html lang="en">
  
  <head>
    <title>User</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" type="text/css" href="libs/materialize/css/materialize.min.css" media="screen, projection">
    <link rel="stylesheet" type="text/css" href="css/default.css">
    <link rel="stylesheet" type="text/css" href="css/toolbar.css">
    <link rel="stylesheet" type="text/css" href="css/user.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
  </head>
  
  <body>
    
    <header>
      <nav>
        <div class="nav-wrapper blue-grey darken-2">
          <a href="index.php" class="logo-icon app-icon"></a>
          <a class="brand-logo hide-on-small-only">User</a>
          
          <ul class="right">
            <li>
              <?php
              if (!$isLocalUser) {
                echo "<a id='action_send_msg'><i class='material-icons left'>message</i>Send message</a>";
              }
              ?>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    
    <?php if (!$isLocalUser) { ?>
      <div class="card-panel z-depth-2 msg-panel">
        <p>
          To: <?php echo $user->user; ?>
        </p>
        <div>
          <div class="row">
            <div class="input-field col s12">
              <textarea id="msg" class="inverse-text materialize-textarea"></textarea>
              <label for="msg">Message</label>
            </div>
          </div>
          <a id="send_msg" class="btn blue darken-4"><i class="material-icons left">send</i>send</a>
        </div>
      </div>
    <?php } ?>
    
    <div class="container">
      <div class="row">
        <div class="col s12 m7">
          <div class="card-panel cyan darken-4">
            <?php
            echo "<img class='avatar' src='$user->avatar'/>";
            echo "<span class='user'>$user->user<span>";
            ?>
          </div>
        </div>
        
        <div class="col m5 hide-on-small-only">
          <div class="card-panel lime darken-3">
            <?php
            echo "<span class='score center'>$user->score</span>";
            ?>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col s12 m7">
          <div class="card-panel grey darken-3">
            <?php
            $inf = (empty($user->information)) ? "<i>No information about $user->user</i>" : $user->information;
            echo "<p>$inf</p>";
            ?>
          </div>
        </div>
        
        <div class="col m5 hide-on-small-only">
          <div class="card-panel blue darken-3">
            <?php
            echo "<span class='sgc-points center'>$user->sgcPoints</span>";
            ?>
          </div>
        </div>
      </div>
      
      <div class="row hide-on-med-and-up">
        <div class="col s8 offset-s2">
          <div class="card-panel lime darken-3">
            <?php
            echo "<span class='score center'>$user->score</span>";
            ?>
          </div>
        </div>
      </div>
      
      <div class="row hide-on-med-and-up">
        <div class="col s8 offset-s2">
          <div class="card-panel blue darken-4">
            <?php
            echo "<span class='sgc-points center'>$user->sgcPoints</span>";
            ?>
          </div>
        </div>
      </div>
    </div>
    
    <?php if ($isLocalUser) { ?>
      <a class="btn-floating btn-large waves-effect waves-light cyan accent-4 edit" href="edit_account.php">
        <i class="material-icons">edit</i>
      </a>
    <?php } ?>
    
    <script src="libs/jquery-dist-3.5.0/jquery.min.js"></script>
    <script src="libs/materialize/js/materialize.min.js"></script>
    <script src="js/user.js"></script>
  
  </body>

</html>
