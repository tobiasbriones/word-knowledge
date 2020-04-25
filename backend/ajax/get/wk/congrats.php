<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

use App\Database\UsersDB;
use App\UserManager;

require "../../../Src/Database/UsersDB.php";
require "../../../Src/UserManager.php";
require "../../../Src/WKUserManager.php";

if (!isset($_POST["category"]) || !is_numeric($_POST["category"])) {
    exit();
}

$category = $_POST["category"];

try {
    $conn = UsersDB::newInstance();
    $userId = UserManager::retrieveUserId();
    
    if ($userId == UserManager::NO_USER) {
        exit();
    }
    $progress = WKUserManager::getProgress($conn, $userId, $category);
    $prg = $progress["progress"];
    
    if ($prg == 0) {
        $prg = 1;
    }
    $percent = $progress["score"] / $prg;
}
catch (PDOException $e) {
    echo "Failed to connect";
    exit();
}
?>

<div id="congrats" class="card-panel blue-grey darken-4">
  <div class="cgt-score">
		<span class="center">
			<?php echo "$percent%"; ?>
		</span>
  </div>
  
  <div class="cgt-opts">
    <button class="btn green">reset</button>
  </div>
</div>
