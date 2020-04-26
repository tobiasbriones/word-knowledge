<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */
namespace App;

// I will get rid of this one
class ValidatorManager {
    
    public static function exists($conn, $userName) {
        $result = $conn->prepare("SELECT user_id FROM register WHERE user = ? LIMIT 1");
        
        $result->execute(array($userName));
        $rows = $result->fetchAll();
        
        if (count($rows) == 0) {
            return false;
        }
        return true;
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
    
}
