<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace App\Model\WK;

use App\Model\Model;

// Temporal Category
class Category extends Model {

    private $name;
    private $subcategories;
    private $pairs;
    private $image;

    public function __construct($conn, $id = -1) {
        parent::__construct($id);
        $this->name = "";
        $this->subcategories = [];
        $this->pairs = [];

        $result = $conn->query("SELECT name, subcategories FROM reg WHERE id = '$id'");
        $rows = $result->fetchAll();

        $row = $rows[0];
        $this->name = $row["name"];
        $this->subcategories = json_decode($row["subcategories"], true);
        $this->image = "img/categories/$id.jpg";

        sort($this->subcategories);

        $result = $conn->query("SELECT * FROM cat_$id ORDER BY english ASC");
        $this->pairs = $result->fetchAll();
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getSubcategories() {
        return $this->subcategories;
    }

    /**
     * @param array $subcategories
     */
    public function setSubcategories($subcategories) {
        $this->subcategories = $subcategories;
    }

    /**
     * @return array
     */
    public function getPairs() {
        return $this->pairs;
    }

    /**
     * @param array $pairs
     */
    public function setPairs($pairs) {
        $this->pairs = $pairs;
    }

    /**
     * @return mixed
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image) {
        $this->image = $image;
    }

    //
    //    public function __construct($conn, $id, $loadPairs = true) {
    //        $result = $conn->query("SELECT name, subcategories FROM reg WHERE id = '$id'");
    //        $rows = $result->fetchAll();
    //
    //        if (count($rows) != 1) {
    //            $this->exists = false;
    //            return;
    //        }
    //        $row = $rows[0];
    //        $this->id = $id;
    //        $this->name = $row["name"];
    //        $this->subcategories = json_decode($row["subcategories"], true);
    //        $this->image = "img/categories/$this->id.jpg";
    //        $this->exists = true;
    //
    //        sort($this->subcategories);
    //        if (!$loadPairs) {
    //            return;
    //        }
    //
    //        $result = $conn->query("SELECT * FROM cat_$id ORDER BY english ASC");
    //        $this->pairs = $result->fetchAll();
    //    }
    //
    //    public function getUserPairs($cps) {
    //        $userPairs = array();
    //
    //        foreach ($this->pairs as $pair) {
    //            if ($cps != null && in_array($pair["id"], $cps)) {
    //                continue;
    //            }
    //            $userPairs[] = $pair;
    //        }
    //        shuffle($userPairs);
    //        return $userPairs;
    //    }
    //
    //    public function __get($field) {
    //        return $this->$field;
    //    }

}
