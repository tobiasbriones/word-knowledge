<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

require "../src/database/WKDataDB.php";
require "../src/model/wk/Category.php";

$categories = array();
$lc = null;

try {
    $conn = WKDataDB::newInstance();
    
    for ($i = 1; $i < 10; $i++) {
        $categories[] = new Category($conn, $i, false);
    }
    $conn = null;
}
catch (PDOException $e) {
    echo "<p class='white-text'><strong>Failed to load</strong></p>";
}

if (isset($_COOKIE["lc"])) {
    $id = ((integer) $_COOKIE["lc"]) - 1;
    $lc = $categories[$id];
}

function cell($id, $title, $image) {
    $cell = "
    <div class='cat-cell' data-cat='$id' style='background: url($image); background-size: 100% 100%;'>
      <div class='cat-title'>
        <span>$title</span>
      </div>
		</div>";
    echo $cell;
}

?>

<aside>
  <div class="card-panel wk-search">
    <div class="row">
      <div class="input-field col s12">
        <input id="word-search" class="inverse-text" type="text" />
        <label for="word-search">
          Search for a word or verb
        </label>
      </div>
    </div>
    
    <div class="wk-results"></div>
  </div>
    
    <?php if ($lc != null) { ?>
      <div class="card-panel grey darken-4 lc">
        <div class="lc-image"
             style="background-image: url(<?php echo $lc->image; ?>); background-size: 100% 100%;"></div>
        <button id="continue" class="btn blue darken-4" data-cat="<?php echo $lc->id; ?>">
          continue
        </button>
      </div>
        <?php
    }
    else {
        $length = count($categories) - 1;
        $lc = $categories[rand(0, $length)]; ?>
      
      <div class="card-panel grey darken-4 lc">
        <div class="lc-image"
             style="background-image: url(<?php echo $lc->image; ?>); background-size: 100% 100%;"></div>
        <button id="continue" class="btn blue darken-4" data-cat="<?php echo $lc->id; ?>">maybe</button>
      </div>
    <?php } ?>
</aside>

<div class="content">
  <div class="categories">
      <?php
      foreach ($categories as $category) {
          cell($category->id, $category->name, $category->image);
      }
      ?>
  </div>
</div>
