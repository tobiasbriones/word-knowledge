<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

class Category {
    
    private $id;
    private $name;
    private $subcategories;
    private $pairs;
    private $image;
    private $exists;
    
    public function __construct($conn, $id, $loadPairs = true) {
        $result = $conn->query("SELECT name, subcategories FROM reg WHERE id = '$id'");
        $rows = $result->fetchAll();
        
        if (count($rows) != 1) {
            $this->exists = false;
            return;
        }
        $row = $rows[0];
        $this->id = $id;
        $this->name = $row["name"];
        $this->subcategories = json_decode($row["subcategories"], true);
        $this->image = "img/categories/$this->id.jpg";
        $this->exists = true;
        
        sort($this->subcategories);
        if (!$loadPairs) {
            return;
        }
        
        $result = $conn->query("SELECT * FROM cat_$id ORDER BY english ASC");
        $this->pairs = $result->fetchAll();
    }
    
    public function getUserPairs($cps) {
        $userPairs = array();
        
        foreach ($this->pairs as $pair) {
            if ($cps != null && in_array($pair["id"], $cps)) {
                continue;
            }
            $userPairs[] = $pair;
        }
        shuffle($userPairs);
        return $userPairs;
    }
    
    public function __get($field) {
        return $this->$field;
    }
    
}
