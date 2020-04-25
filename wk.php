<!--
  -- Copyright (c) 2015 Tobias Briones
  -- All rights reserved.
  --
  -- This source code is licensed under the BSD 3-Clause license found in the
  -- LICENSE file in the root directory of this source tree.
  -->

<?php
require_once "vendor/autoload.php";

use App\Database\WKDataDB;
use App\Model\WK\Category;

if (!isset($_GET["c"])) {
  header("Location: index.php?go=WK");
  exit();
}

$category = null;

// -------------------- CONNECT -------------------- //
try {
  $wkConn = WKDataDB::newInstance();
  $category = new Category($wkConn, (int) $_GET["c"]);
  
}
catch (Exception $e) {
  echo "<strong>Failed to connect</strong>";
  exit();
}

// -------------------- SAVE AS LAST CATEGORY -------------------- //
setcookie("lc", $category->getId(), time() + (60 * 60 * 24 * 7 * 4 * 12));
?>

<!doctype html>
<html lang="en">
  
  <head>
    <title>Word Knowledge</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto&display=swap">
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
            <?php echo $category->getName(); ?>
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
              <p>
                <label>
                  <input id="mode_game" type="checkbox" class="filled-in" data-group="mode_study">
                  <span>Game</span>
                </label>
              </p>
              <p>
                <label>
                  <input id="mode_study" type="checkbox" class="filled-in" data-group="mode_game">
                  <span>Study</span>
                </label>
              </p>
            </div>
          </div>
          
          <div class="menu-item row">
            <div class="row">
              <span>Order</span>
            </div>
            <div class="row">
              <p>
                <label>
                  <input id="order_impartial" type="checkbox" class="filled-in" data-group="order_subcategories">
                  <span>Impartial</span>
                </label>
              </p>
              <p>
                <label>
                  <input id="order_subcategories"  type="checkbox" class="filled-in" data-group="order_impartial">
                  <span>Subcategories</span>
                </label>
              </p>
            </div>
          </div>
        </div>
      </nav>
    </header>
    
    <div id="subcategories" class="subcategories z-depth-1">
      <ul>
        <?php
        foreach ($category->getSubcategories() as $subcategory) {
          echo "<li class='unselectable' data-sc='$subcategory'><span>$subcategory</span></li>";
        }
        ?>
      </ul>
    </div>
    
    <div class="container">
      <div class="content" data-category="<?php echo $category->getId(); ?>">
        <div class="game">
        </div>
        
        <div class="study">
        </div>
      </div>
    </div>
  
    <script src="libs/jquery-dist-3.5.0/jquery.min.js"></script>
    <script src="libs/materialize/js/materialize.min.js"></script>
    <script src="libs/js-cookie-2.2.1/js.cookie-2.2.1.min.js"></script>
    <script src="js/wk.js"></script>
  
  </body>

</html>
