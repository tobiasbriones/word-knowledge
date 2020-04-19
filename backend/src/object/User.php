<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

class User {
  
  private $id;
  private $user;
  private $information;
  private $folder;
  private $avatar;
  private $score;
  private $sgcPoints;
  private $userExists;
  
  public function __construct($conn, $userId) {
    // -------------------- GET THE USER -------------------- //
    $result = $conn->query("SELECT user, information FROM register WHERE user_id = '$userId'");
    $rows = $result->fetchAll();
    
    if (count($rows) != 1) {
      $this->userExists = false;
      return;
    }
    
    // -------------------- GET REGISTRATION DATA -------------------- //
    $row = $rows[0];
    $this->userExists = true;
    
    $this->id = $userId;
    $this->user = $row["user"];
    $this->information = $row["information"];
    $this->folder = "backend/storage/users/$this->id" . bin2hex($this->user);
    $this->avatar = $this->folder . "/avatar";
    
    if (!file_exists($this->avatar)) {
      $this->avatar = "img/default_avatar.png";
    }
    
    // -------------------- GET USER DATA -------------------- //
    $query = "SELECT score, sgc_points FROM user_data WHERE user_id = '$userId'";
    $result = $conn->query($query);
    $row = $result->fetchAll()[0];
    
    $this->score = $row["score"];
    $this->sgcPoints = $row["sgc_points"];
  }
  
  public static function findUserByName($conn, $user) {
    $result = $conn->prepare("SELECT user_id FROM register WHERE user = ?");
    
    $result->execute(array($user));
    $rows = $result->fetchAll();
    
    if (count($rows) != 1) {
      return null;
    }
    return new User($conn, $rows[0]["user_id"]);
  }
  
  public function __get($field) {
    return $this->$field;
  }
  
}
