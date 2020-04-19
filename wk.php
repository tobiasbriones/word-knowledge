<!--
  -- Copyright (c) 2015 Tobias Briones
  -- All rights reserved.
  --
  -- This source code is licensed under the BSD 3-Clause license found in the
  -- LICENSE file in the root directory of this source tree.
  -->

<?php
require "backend/src/databases/WKDataDB.php";
require "backend/src/object/wk/Category.php";

if (!isset($_GET["c"])) {
  header("Location: index.php?go=wk");
  exit();
}

$category = null;

// -------------------- CONNECT -------------------- //
try {
  $wkConn = WKDataDB::newInstance();
  $category = new Category($wkConn, $_GET["c"], false);
  
  if (!$category->exists) {
    echo "Category doesn't exist";
    exit();
  }
}
catch (PDOException $e) {
  echo "<strong>Failed to connect</strong>";
  exit();
}

// -------------------- SAVE AS LAST CATEGORY -------------------- //
setcookie("lc", $category->id, time() + (60 * 60 * 24 * 7 * 4 * 12));
?>

<!doctype html>
<html lang="en">
  
  <head>
    <title>Word Knowledge</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" type="text/css" href="libs/materialize/css/materialize.min.css" media="screen, projection">
    <link rel="stylesheet" type="text/css" href="css/default.css">
    <link rel="stylesheet" type="text/css" href="css/toolbar.css">
    <link rel="stylesheet" type="text/css" href="css/wk/menu.css">
    <link rel="stylesheet" type="text/css" href="css/wk/wk.css">
    <link rel="stylesheet" type="text/css" href="css/wk/congrats.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
  </head>
  
  <body>
    
    <header>
      <nav id="toolbar" class="grey darken-4">
        <!-- --------------------------  TOOLBAR  -------------------------- -->
        <div class="nav-wrapper">
          <a href="index.php?go=wk" class="logo-icon wk-icon"></a>
          <a class="brand-logo hide-on-small-only">
            <?php echo $category->name; ?>
          </a>
          <ul class="right">
            <li>
              <a id="action_options">Options</a>
            </li>
          </ul>
        </div>
        
        <!-- -----------------------  TOOLBAR MENU  ------------------------ -->
        <div class="toolbar-menu">
          <div class="menu-item row">
            <div class="row">
              <span>Mode</span>
            </div>
            
            <div class="row">
              <p class="checkbox">
                <input id="mode_game" class="filled-in" type="checkbox" data-group="mode_study" />
                <label for="mode_game">Game</label>
              </p>
              <p class="checkbox">
                <input id="mode_study" class="filled-in" type="checkbox" data-group="mode_game" />
                <label for="mode_study">Study</label>
              </p>
            </div>
          </div>
          
          <div class="menu-item row">
            <div class="row">
              <span>Order</span>
            </div>
            <div class="row">
              <p class="checkbox">
                <input id="order_impartial" class="filled-in" type="checkbox" data-group="order_subcategories" />
                <label for="order_impartial">Impartial</label>
              </p>
              <p class="checkbox">
                <input id="order_subcategories" class="filled-in" type="checkbox" data-group="order_impartial" />
                <label for="order_subcategories">Subcategories</label>
              </p>
            </div>
          </div>
        </div>
      </nav>
    </header>
    
    <div id="subcategories" class="subcategories z-depth-1">
      <ul>
        <?php
        foreach ($category->subcategories as $subcategory) {
          echo "<li class='unselectable' data-sc='$subcategory'><span>$subcategory</span></li>";
        }
        ?>
      </ul>
    </div>
    
    <div class="container">
      <div class="content" data-category="<?php echo $category->id; ?>">
        <div class="game">
        </div>
        
        <div class="study">
        </div>
      </div>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script>
      window.jQuery || document.write('<script src="libs/jquery-dist-2.1.4/jquery.min.js"><\/script>');
    </script>
    <script src="libs/materialize/js/materialize.min.js"></script>
    <script src="libs/js-cookie-2.0.3/js.cookie-2.0.3.min.js"></script>
    <script src="libs/jquery.nicescroll-3.5.6/jquery.nicescroll.min.js"></script>
    <script src="js/wk.js"></script>
  
  </body>

</html>
