<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */
namespace App;

class ValidatorManager {
    
    public static function isValidUser($conn, $user, &$errors) {
        $ok = true;
        
        if (ValidatorManager::isValid($user)) {
            $trim = trim($user);
            
            if ($user != $trim) {
                $errors .= "Username: Must not have any whitespaces at start/end<br/><br/>";
                $ok &= false;
            }
            if (strlen($user) < 2) {
                $errors .= "Username: Must have at least 2 characters length<br/><br/>";
                $ok &= false;
            }
            else if (strlen($user) > 25) {
                $errors .= "Username: Must have a maximum of 25 characters length<br/><br/>";
                $ok &= false;
            }
            if (ValidatorManager::exists($conn, $user)) {
                $errors .= "\"$user\" already exists<br/><br/>";
                $ok &= false;
            }
        }
        else {
            $errors .= "Username: Put a valid value<br/><br/>";
            $ok &= false;
        }
        return $ok;
    }
    
    public static function isValid($var) {
        $trim = trim($var);
        
        if (isset($var) && !empty($trim)) {
            return true;
        }
        return false;
    }
    
    public static function exists($conn, $userName) {
        $result = $conn->prepare("SELECT user_id FROM register WHERE user = ? LIMIT 1");
        
        $result->execute(array($userName));
        $rows = $result->fetchAll();
        
        if (count($rows) == 0) {
            return false;
        }
        return true;
    }
    
    public static function isValidPassword($password, $confirmPassword, &$errors) {
        $ok = true;
        
        if (ValidatorManager::isValid($password) && ValidatorManager::isValid($confirmPassword)) {
            if (strlen($password) < 6) {
                $errors .= "Password: Must have at least 6 characters length<br/><br/>";
                $ok &= false;
            }
            else if (strlen($password) > 50) {
                $errors .= "Password: Must have a maximum of 50 characters length<br/><br/>";
                $ok &= false;
            }
            if ($password != $confirmPassword) {
                $errors .= "Password: Don't match<br/><br/>";
                $ok &= false;
            }
        }
        else {
            $errors .= "Password: Put a valid value<br/><br/>";
            $ok &= false;
        }
        return $ok;
    }
    
    public static function isValidAvatar($avatarUploaded, &$errors) {
        $ok = true;
        
        if (!isset($avatarUploaded) || empty($avatarUploaded) || getimagesize($avatarUploaded) == false) {
            $errors .= "Avatar: Isn't a valid file image<br/><br/>";
            $ok &= false;
        }
        else if (!((exif_imagetype($avatarUploaded) == IMAGETYPE_PNG)
                   || (exif_imagetype($avatarUploaded) == IMAGETYPE_JPEG))) {
            $errors .= "Avatar: Isn't a valid type of image. Only PNG and JPG formats are allowed<br/><br/>";
            $ok &= false;
        }
        return $ok;
    }
    
    public static function isValidUserInfo($info, &$errors) {
        if (strlen($info) > 300) {
            $errors .= "User info must have a maximum of 300 characters";
            return false;
        }
        return true;
    }
    
}
