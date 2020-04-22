<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

require_once "Config.php";

class WKDataDB {
    
    const PASSWORD = "";
    const DATABASE = "wk_data";
    
    public static function newInstance() {
        $dsn = "mysql:host=" . Config::HOST . ";dbname=" . WKDataDB::DATABASE;
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        $conn = new PDO($dsn, Config::ROOT_USER, WKDataDB::PASSWORD, $options);
        
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
    
}
