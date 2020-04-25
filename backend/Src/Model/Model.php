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

class Model implements VarType {
    
    private $id;
    
    /**
     * Constructs an existing user with its specified id and a new user if the
     * id param is not set which is set to -1 by default.
     *
     * @param int $id user id, it must be non-negative and only -1 when the user
     *                does not exists in the Database
     *
     * @throws Exception if the passed user id is not a non-negative integer
     * number and it is not -1
     */
    public function __construct($id = -1) {
        if (!(is_int($id) && $id >= -1)) {
            $msg = "
                The user id must be a non-negative integer number for existing
                users and -1 (by default) for new users.
            ";
            throw new Exception($msg);
        }
        $this->id = $id;
    }
    
    /**
     * Returns the user id. If the user is new, its id is -1.
     *
     * @return int the user id
     */
    public final function getId() {
        return $this->id;
    }
    
    /**
     * Checks whether a variable is of a specified type. If not, then throws an
     * exceptions with the specified failure message.
     *
     * @param $var     mixed variable to check
     * @param $type    int expected type from var
     * @param $failMsg string message to throw if check fails
     *
     * @throws Exception if the var parameter is not of the specified type
     */
    protected static function checkType($var, $type, $failMsg) {
        switch ($type) {
            case Model::VAR_TYPE_INT:
                if (!is_int($var)) throw new Exception($failMsg);
                break;
            case Model::VAR_TYPE_POSITIVE_INT:
                if (!(is_int($var) && $var > 0)) throw new Exception($failMsg);
                break;
            case Model::VAR_TYPE_NEGATIVE_INT:
                if (!(is_int($var) && $var < 0)) throw new Exception($failMsg);
                break;
            case Model::VAR_TYPE_NON_NEGATIVE_INT:
                if (!(is_int($var) && $var >= 0)) throw new Exception($failMsg);
                break;
            case Model::VAR_TYPE_NON_POSITIVE_INT:
                if (!(is_int($var) && $var <= 0)) throw new Exception($failMsg);
                break;
            case Model::VAR_TYPE_FLOAT:
                if (!is_float($var)) throw new Exception($failMsg);
                break;
            case Model::VAR_TYPE_DOUBLE:
                if (!is_double($var)) throw new Exception($failMsg);
                break;
            case Model::VAR_TYPE_LONG:
                if (!is_long($var)) throw new Exception($failMsg);
                break;
            case Model::VAR_TYPE_BOOL:
                if (!is_bool($var)) throw new Exception($failMsg);
                break;
            case Model::VAR_TYPE_STR:
                if (!is_string($var)) throw new Exception($failMsg);
                break;
            case Model::VAR_TYPE_NON_EMPTY_STR:
                if (!is_string($var) || empty(trim($var))) throw new Exception($failMsg);
                break;
            case Model::VAR_TYPE_OBJECT:
                if (!is_object($var)) throw new Exception($failMsg);
                break;
            case Model::VAR_TYPE_ARRAY:
                if (!is_array($var)) throw new Exception($failMsg);
                break;
        }
    }
    
}
