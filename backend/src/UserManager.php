<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

class UserManager {
    
    const NO_USER = -1;
    
    // -------------------- LOGIN - LOGOUT - GET USER -------------------- //
    public static function loginUser($userId, $remember) {
        $time = ($remember) ? (time() + (60 * 60 * 24 * 7 * 4 * 8)) : 0;
        $data = UserManager::codecId($userId);
        
        UserManager::logOut();
        setcookie("user", $data, $time, "/");
    }
    
    private static function codecId($id) {
        return $id;
    }
    
    public static function logOut() {
        // Clear WK data
        session_start();
        unset($_SESSION["cps"]);
        session_unset();
        session_destroy();
        unset($_COOKIE["lc"]);
        setcookie("lc", "", 1, "/");
        
        // Clear general data
        unset($_COOKIE["user"]);
        setcookie("user", "", 1, "/");
    }
    
    public static function retrieveUser($conn) {
        $userId = UserManager::retrieveUserId();
        
        if ($userId == UserManager::NO_USER) {
            return null;
        }
        return new User($conn, $userId);
    }
    
    // -------------------- SET USER DATA -------------------- //
    
    public static function retrieveUserId() {
        if (!isset($_COOKIE["user"])) {
            return UserManager::NO_USER;
        }
        return UserManager::decodeId($_COOKIE["user"]);
    }
    
    private static function decodeId($data) {
        return (int) $data;
    }
    
    // -------------------- CLASS METHODS -------------------- //
    
    public static function sendMessage($conn, $sender, $receiver, $msg) {
        $newMessages = UserManager::getNewMessages($conn, $receiver);
        
        if ($newMessages == null) {
            throw new PDOException("Error Processing Request", 1);
        }
        
        $sendQuery = "INSERT INTO messages (sender, receiver, message) VALUES (?, ?, ?)";
        $rnmArray = json_decode($newMessages, true);
        $result = $conn->prepare($sendQuery);
        
        $result->execute(array($sender, $receiver, $msg));
        
        if (!in_array($sender, $rnmArray)) {
            $rnmArray[] = $sender;
            $newMessages = json_encode($rnmArray);
            $updateQuery = "UPDATE user_data SET new_messages = '$newMessages' WHERE user_id = '$receiver'";
            
            $conn->exec($updateQuery);
        }
    }
    
    private static function getNewMessages($conn, $userId) {
        $nmQuery = "SELECT new_messages FROM user_data WHERE user_id = '$userId'";
        $result = $conn->query($nmQuery);
        $rows = $result->fetchAll();
        
        if (count($rows) != 1) {
            return null;
        }
        return $rows[0]["new_messages"];
    }
    
    public static function setMessagesViewed($conn, $userId, $conversationItem) {
        $newMessages = UserManager::getNewMessages($conn, $userId);
        
        if ($newMessages == null) {
            throw new PDOException("Error Processing Request", 1);
        }
        $unmArray = json_decode($newMessages, true);
        
        unset($unmArray[$conversationItem]);
        
        $newMessages = json_encode($unmArray);
        
        $conn->exec("UPDATE user_data SET new_messages = '$newMessages' WHERE id = '$userId'");
    }
    
}
