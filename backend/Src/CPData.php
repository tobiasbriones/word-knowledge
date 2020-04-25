<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace App;

class CPData {
    
    private $category;
    private $pair;
    private $fails;
    
    public function __construct($category, $pair, $fails) {
        $this->category = $category;
        $this->pair = $pair;
        $this->fails = $fails;
    }
    
    public static function getUserCheckPoints() {
        if (!isset($_SESSION['cps'])) {
            return null;
        }
        $array = array();
        $checkPoints = json_decode($_SESSION['cps'], true);
        
        if ($checkPoints == null) {
            return null;
        }
        foreach ($checkPoints as $cp) {
            $cpData = new CPData($cp['category'], $cp['pair'], $cp['fails']);
            $array[] = $cpData;
        }
        return $array;
    }
    
    public function getData() {
        return array('category' => $this->category, 'pair' => $this->pair, 'fails' => $this->fails);
    }
    
    public function __get($field) {
        return $this->$field;
    }
    
}
