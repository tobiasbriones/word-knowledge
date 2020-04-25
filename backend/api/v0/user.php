<?php
/*
 * Copyright (c) 2015, 2020 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

require_once "../../../vendor/autoload.php";

use App\Api\V0\Controller\UserController;
use App\Database\UsersDB;
use App\Model\User;

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Max-Age: 600");
header("Content-Type: application/json; charset=UTF-8");

// Yes, writing variables with underscore here because I've realized about some philosophies about the coding styles ...
// It's because this file doesn't belong to Src/, it's just for scripting
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case "GET":
        read();
        break;
    case "POST":
        create();
        break;
    case "PUT":
        break;
    case "DELETE":
        break;
}

// Old temporal code for controlling the requests

function read() {
    function check_input() {
        $params_set = true;
        $params_set &= isset($_GET["id"]);
        
        if (!$params_set) {
            $msg = "Wrong arguments or number of arguments. Check the API documentation";
            throw new Exception($msg);
        }
        return true;
    }
    
    function check_params() {
        if (!is_numeric($_GET["id"]) || !is_int((int) $_GET["id"]) || $_GET["id"] < 0) {
            $msg = "The user id is a non-negative integer number";
            throw new Exception($msg);
        }
        return true;
    }
    
    try {
        check_input();
        check_params();
    }
    catch (Exception $e) {
        error($e->getMessage(), 400);
        return;
    }
    $user_id = (int) $_GET["id"];
    $user_controller = new UserController(UsersDB::newInstance());
    
    try {
        $user = $user_controller->read($user_id);
    }
    catch (Exception $e) {
        error($e->getMessage(), 500);
        return;
    }
    send($user);
}

function create() {
    /**
     * Checks for the client input whether the required params have been set.
     *
     * @return bool <code>true</code> if and only if the required params are set
     *              from the client's input
     * @throws Exception if the required params are not set
     */
    function check_input() {
        $params_set = true;
        $params_set &= isset($_POST["name"]);
        $params_set &= isset($_POST["password"]);
        $params_set &= isset($_POST["confirm_password"]);
        
        if (!$params_set) {
            $msg = "Wrong arguments or number of arguments. Check the API documentation";
            throw new Exception($msg);
        }
        return true;
    }
    
    /**
     * Returns <code>true</code> if and only if the params are valid.
     *
     * @return bool <code>true</code> if and only if the params are valid
     * @throws Exception if any of the params are wrong
     */
    function check_params() {
        if ($_POST["password"] !== $_POST["confirm_password"]) {
            $msg = "Passwords do not match";
            throw new Exception($msg);
        }
        return true;
    }
    
    /**
     * Returns the user object with the specified client's input.
     *
     * @return User the user object with the specified client's input
     * @throws Exception if the user Model rejects the client's input
     */
    function get_model() {
        $name = $_POST["name"];
        $information = $_POST["information"];
        $user = new User();
        
        $user->setName($name);
        $user->setInformation($information);
        return $user;
    }
    
    $new_user = null;
    
    try {
        check_input();
        check_params();
        $new_user = get_model();
    }
    catch (Exception $e) {
        error($e->getMessage(), 400);
        return;
    }
    
    $password = $_POST["password"];
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    
    // This should never happen
    if ($hashed_password === null || $hashed_password === false) {
        $msg = "Fail to create user, try again or use another password";
        
        error($msg, 500);
        exit;
    }
    
    $params = [
        "hashed_password" => $hashed_password
    ];
    $user_controller = new UserController(UsersDB::newInstance());
    
    //$avatarUploaded = $_FILES["avatar"]["tmp_name"];
    try {
        $user_controller->create($new_user, $params);
    }
    catch (Exception $e) {
    }
    send(["message" => "Ok"]);
}

/**
 * Sends a 200 HTTP response code and the given object.
 *
 * @param $response array associative array to send as a json response
 */
function send($response) {
    http_response_code(200);
    echo json_encode($response);
}

/**
 * Sends the given response code and a message with the specified error.
 *
 * @param $msg           string message to send as a response
 * @param $response_code int HTTP response code
 * @param $about         array list of the names of the params related to this error
 */
function error($msg, $response_code, $about = []) {
    http_response_code($response_code);
    echo json_encode(["message" => $msg, "about" => json_encode($about)]);
}
