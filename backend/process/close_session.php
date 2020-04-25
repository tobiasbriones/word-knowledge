<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

require_once "../../vendor/autoload.php";

use App\UserManager;

UserManager::logOut();
header("Location: ../../index.php");
