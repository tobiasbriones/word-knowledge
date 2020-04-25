<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

class Pair {
    
    private $id;
    private $english;
    private $spanish;
    private $subcategory;
    
    public function __construct($id = -1) {
        $this->id = $id;
    }
    
    public function __get($field) {
        return $this->$field;
    }
    
    public function __set($field, $value) {
        $this->$field = $value;
        return $this;
    }
    
}
