<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace App\Database;

use PDO;

class UsersDB {

    public static function newInstance() {
        $dns = "mysql:host=" . Config::HOST . ";dbname=" . UsersDB::DATABASE;
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        $conn = new PDO($dns, Config::ROOT_USER, UsersDB::PASSWORD, $options);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }

    const PASSWORD = "";
    const DATABASE = "users";

}
