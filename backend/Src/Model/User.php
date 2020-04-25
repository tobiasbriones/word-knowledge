<?php
/*
 * Copyright (c) 2015, 2020 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace App\Model;

use Exception;

class User extends Model {
    
    const DEF_SCORE = 0;
    private $name;
    private $information;
    private $score;
    private $sgcPoints;
    
    /**
     * @inheritDoc
     */
    public function __construct($id = -1) {
        parent::__construct($id);
        $this->name = "";
        $this->information = "";
        $this->score = User::DEF_SCORE;
        $this->sgcPoints = User::DEF_SCORE;
    }
    
    /**
     * @param string $name user name
     *
     * @throws Exception if name is not valid
     */
    public function setName($name) {
        Model::checkType(
            $name,
            Model::VAR_TYPE_STR,
            "Name must be a string"
        );
        if (strlen($name) < 2) {
            $failMsg = "The user name must have at least 2 characters length";
            throw new Exception($failMsg);
        }
        if (strlen($name) > 25) {
            $failMsg = "The username must have a maximum of 25 characters length";
            throw new Exception($failMsg);
        }
        $this->name = $name;
    }
    
    /**
     * @param string $information user information, about the user
     *
     * @throws Exception if information is not valid
     */
    public function setInformation($information) {
        Model::checkType(
            $information,
            Model::VAR_TYPE_STR,
            "Information must be a string"
        );
        if (strlen($information) > 500) {
            $failMsg = "The user information must have a maximum of 500 characters length";
            throw new Exception($failMsg);
        }
        $this->information = $information;
    }
    
    /**
     * @param int $score user main score
     *
     * @throws Exception if score is invalid
     */
    public function setScore($score) {
        Model::checkType(
            $score,
            Model::VAR_TYPE_NON_NEGATIVE_INT,
            "Score must be a non-negative integer"
        );
        $this->score = $score;
    }
    
    /**
     * @param int $sgcPoints SGC user points
     *
     * @throws Exception if sgcPoints is invalid
     */
    public function setSgcPoints($sgcPoints) {
        Model::checkType(
            $sgcPoints,
            Model::VAR_TYPE_NON_NEGATIVE_INT,
            "SGC Points must be a non-negative integer"
        );
        $this->sgcPoints = $sgcPoints;
    }
    
    /**
     * Returns the user name.
     *
     * @return string user name
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * Returns the user information.
     *
     * @return string user information
     */
    public function getInformation() {
        return $this->information;
    }
    
    /**
     * Returns the user score.
     *
     * @return int user score
     */
    public function getScore() {
        return $this->score;
    }
    
    /**
     * Returns the user SGC points.
     *
     * @return int user SGC points
     */
    public function getSgcPoints() {
        return $this->sgcPoints;
    }
    
    /**
     * Validates the user password. It returns <code>true</code> if and only if
     * the password is accepted.
     *
     * @param $password string password to check
     *
     * @return bool <code>true</code> if and only if the password is accepted
     * @throws Exception if the password is rejected
     */
    public static function isValidPassword($password) {
        Model::checkType(
            $password,
            Model::VAR_TYPE_NON_EMPTY_STR,
            "Password must not be empty"
        );
        $failMsg = null;
        
        if (strlen($password) < 6) {
            $failMsg = "The password must have at least 6 characters length";
        }
        else if (strlen($password) > 50) {
            $failMsg = "The password must have a maximum of 50 characters length";
        }
        
        if ($failMsg !== null) {
            throw new Exception($failMsg);
        }
        return true;
    }
    
}
