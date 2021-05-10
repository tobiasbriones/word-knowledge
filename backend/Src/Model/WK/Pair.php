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

// Temporal Pair
class Pair extends Model {

    private $english;
    private $spanish;
    private $subcategory;

    public function __construct($id = -1) {
        parent::__construct($id);
        $this->english = "";
        $this->spanish = "";
        $this->subcategory = "";
    }

    /**
     * @return mixed
     */
    public function getEnglish() {
        return $this->english;
    }

    /**
     * @param mixed $english
     */
    public function setEnglish($english) {
        $this->english = $english;
    }

    /**
     * @return mixed
     */
    public function getSpanish() {
        return $this->spanish;
    }

    /**
     * @param mixed $spanish
     */
    public function setSpanish($spanish) {
        $this->spanish = $spanish;
    }

    /**
     * @return mixed
     */
    public function getSubcategory() {
        return $this->subcategory;
    }

    /**
     * @param mixed $subcategory
     */
    public function setSubcategory($subcategory) {
        $this->subcategory = $subcategory;
    }

}
