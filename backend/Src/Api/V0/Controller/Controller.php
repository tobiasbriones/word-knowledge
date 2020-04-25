<?php
/*
 * Copyright (c) 2015, 2020 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace App\Api\V0\Controller;

abstract class Controller {
    
    private $db;

//    public function __construct() {
//        $this->db = null;
//    }

// Temporal constructor
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * @return object the Database connection
     * @throws Exception if the Database is not initialized
     */
    protected final function getDatabase() {
        if ($this->db == null) throw new Exception("Database is not initialized");
        return $this->db;
    }
    
}
