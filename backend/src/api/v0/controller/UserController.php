<?php
/*
 * Copyright (c) 2015, 2020 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

require_once "Controller.php";
require_once "CrudApiController.php";

require_once __DIR__ . "/../../../UserManager.php";

class UserController extends Controller implements CrudApiController {
    
    public function __construct($db) {
        parent::__construct($db);
    }
    
    /**
     * @inheritDoc
     * @throws Exception
     */
    public function create($object, $params = null) {
        $db = $this->getDatabase();
        
        try {
            // -------------------- REGISTER USER -------------------- //
            $catData = $this->getCatData();
            $result = $db->prepare("INSERT INTO register (user, password, information) VALUES (?, ?, ?)");
            
            $result->execute(
                [
                    $object->getName(),
                    $params["hashed_password"],
                    $object->getInformation()
                ]
            );
            
            $result = $db->query("SELECT LAST_INSERT_ID()");
            $userId = $result->fetchAll()[0]["LAST_INSERT_ID()"];
            
            // The first user is the Word Knowledge system with id 0
            if ($userId < 1) {
                throw new PDOException("Error Processing Request", 1);
            }
            $db->exec("INSERT INTO user_data (user_id, new_messages) VALUES ('$userId', '[]')");
            $db->exec("INSERT INTO wk_ud (user_id, categories, write_test) VALUES ('$userId', '$catData', '[]')");
            
            // -------------------- CONFIG USER -------------------- //
            // /backend/storage/users/
            $userStorageFolder = dirname(dirname(dirname(dirname(__DIR__)))) . "/storage/users/";
            $userFolderName = $userId . bin2hex($object->getName());
            $userFolder = $userStorageFolder . $userFolderName;

            if (!mkdir($userFolder)) {
                throw new Exception("Error Processing Request");
            }

//            if (ValidatorManager::isValidAvatar($avatarUploaded, $errors)) {
//                $avatarTargetFile = $userFolder . "/avatar";
//
//                move_uploaded_file($avatarUploaded, $avatarTargetFile);
//            }
            $msg = "Congrats";
            
            UserManager::sendMessage($db, 1, $userId, $msg);
        }
        catch (Exception $e) {
            echo "Couldn't register $e";
            exit();
        }
    }
    
    /**
     * @inheritDoc
     */
    public function read($id = -1) {
        // TODO: Implement read() method.
    }
    
    /**
     * @inheritDoc
     */
    public function update($id, $object, $params = null) {
        // TODO: Implement update() method.
    }
    
    /**
     * @inheritDoc
     */
    public function delete($id) {
        // TODO: Implement delete() method.
    }
    
    private function getCatData() {
        return '{"_1":{"progress":0,"score":0,"cps":[]},"_2":{"progress":0,"score":0,"cps":[]},"_3":{"progress":0,"score":0,"cps":[]},"_4":{"progress":0,"score":0,"cps":[]},"_5":{"progress":0,"score":0,"cps":[]},"_6":{"progress":0,"score":0,"cps":[]},"_7":{"progress":0,"score":0,"cps":[]},"_8":{"progress":0,"score":0,"cps":[]}}';
    }

//
//    public function __construct($conn, $userId) {
//        // -------------------- GET THE USER -------------------- //
//        $result = $conn->query("SELECT user, information FROM register WHERE user_id = '$userId'");
//        $rows = $result->fetchAll();
//
//        if (count($rows) != 1) {
//            $this->userExists = false;
//            return;
//        }
//
//        // -------------------- GET REGISTRATION DATA -------------------- //
//        $row = $rows[0];
//        $this->userExists = true;
//
//        $this->id = $userId;
//        $this->name = $row["user"];
//        $this->information = $row["information"];
//        $this->folder = "backend/storage/users/$this->id" . bin2hex($this->name);
//        $this->avatar = $this->folder . "/avatar";
//
//        if (!file_exists($this->avatar)) {
//            $this->avatar = "img/default_avatar.png";
//        }
//
//        // -------------------- GET USER DATA -------------------- //
//        $query = "SELECT score, sgc_points FROM user_data WHERE user_id = '$userId'";
//        $result = $conn->query($query);
//        $row = $result->fetchAll()[0];
//
//        $this->score = $row["score"];
//        $this->sgcPoints = $row["sgc_points"];
//    }
//
//    public static function findUserByName($conn, $user) {
//        $result = $conn->prepare("SELECT user_id FROM register WHERE user = ?");
//
//        $result->execute(array($user));
//        $rows = $result->fetchAll();
//
//        if (count($rows) != 1) {
//            return null;
//        }
//        return new User($conn, $rows[0]["user_id"]);
//    }
}
