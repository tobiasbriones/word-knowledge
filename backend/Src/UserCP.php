<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace App;

class UserCP {
    
    private $user;
    private $category;
    private $checkPoints;
    private $checkPointsSC;
    
    public function __construct($userConn, $userId, $category, $loadSC = false, $dataConn = null) {
        $result = $userConn->query("SELECT categories FROM user_data WHERE id = '$userId'");
        $rows = $result->fetchAll();
        
        if (count($rows) != 1) {
            return;
        }
        $userRow = $rows[0];
        $categories = json_decode($userRow['categories'], true);
        $this->checkPoints = $categories['_' . $category]['cps'];
        
        if ($loadSC) {
            $this->checkPointsSC = array();
            
            foreach ($this->checkPoints as $cp) {
                $result = $dataConn->query("SELECT subcategory FROM cat_$category WHERE id = '$cp'");
                $subcategory = $result->fetchAll()[0]['subcategory'];
                
                $this->checkPointsSC[$subcategory][] = $cp;
            }
        }
        else {
            $this->checkPointsSC = null;
        }
    }
    
    public function toJSONCP() {
        return json_encode($this->checkPoints);
    }
    
    public function __get($field) {
        return $this->$field;
    }
    
    public function __set($field, $value) {
        $this->$field = $value;
        return $this;
    }
    
}
