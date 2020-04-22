<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

if (
    !isset($_POST["user"])
    || !isset($_POST["score"])
    || !isset($_POST["sgc"])
    || !isset($_POST["nm"])
    || !is_numeric($_POST["score"])
    || !is_numeric($_POST["sgc"])
    || !is_numeric($_POST["nm"])
) {
    exit();
}

header("Content-Type: text/html;charset=utf-8");
$user = $_POST["user"];
$score = $_POST["score"];
$sgc = $_POST["sgc"];
$nm = $_POST["nm"];

function printUserPanel() {
    global $score, $sgc, $nm;
    ?>
  <div class="card-panel score">
    <span class="center inverse-text">
      <?php echo $score; ?>
    </span>
  </div>
  
  <div class="msg">
    <div <?php if ($nm == 0) echo "style='display:none'"; ?>>
      <span class="center unselectable"><?php echo $nm; ?></span>
    </div>
  </div>
  
  <div class="sgc">
    <span class="white-text">SGC</span>
    <div class="card-panel blue darken-2">
      <span class="center inverse-text">
        <?php echo $sgc; ?>
      </span>
    </div>
  </div>
    <?php
}

function printHeyReg() {
?>
<div class="hey-reg">
  <p>Create an account or login and join us!</p>
  <p>It's fast and easy and you'll be able to participate, save data and more</p>
  
  <div>
      <?php
      }
      ?>
    <aside>
      <div class="card-panel grey darken-4 user-panel">
          <?php
          if ($user != null) {
              printUserPanel();
          }
          else {
              printHeyReg();
          }
          ?>
      </div>
      <div class="card-panel blue-grey darken-4 something">
      </div>
    </aside>
    
    <div class="content">
    </div>
	