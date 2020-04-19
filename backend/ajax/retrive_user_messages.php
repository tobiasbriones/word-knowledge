<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

require "../src/databases/UsersDB.php";
require "../src/UserManager.php";

$conversations = array();

try {
  $conn = UsersDB::newInstance();
  $userId = UserManager::retriveUserId();
  $sql = "
    SELECT sender, receiver, date, message
    FROM messages
    WHERE receiver = '$userId'
       OR sender = '$userId'
  ";
  
  if ($userId == UserManager::NO_USER) {
    exit();
  }
  $result = $conn->query(sql);
  $rows = $result->fetchAll();
  
  foreach ($rows as $messageObj) {
    $senderId = $messageObj["sender"];
    $receiverId = $messageObj["receiver"];
    $date = $messageObj["date"];
    $message = $messageObj["message"];
    $sender = ($senderId != $userId) ? getSenderName($conn, $senderId) : null;
    $receiver = ($receiverId != $userId) ? getReceiverName($conn, $receiverId) : null;
    $conversationItem = ($sender != null) ? $sender : $receiver;
    $messageType = ($sender != null) ? "input" : "output";
    
    if (!isset($conversations[$conversationItem])) {
      $conversations[$conversationItem] = array();
    }
    $conversationArray = &$conversations[$conversationItem];
    
    $conversationArray[] = array("msgType" => $messageType, "date" => $date, "message" => $message);
  }
}
catch (PDOException $e) {
  exit();
}
header("Content-Type: application/json;charset=utf-8");
echo json_encode($conversations);

function getSenderName($conn, $senderId) {
  if ($senderId == 0) {
    return "SGC Learning";
  }
  return $conn->query("SELECT user FROM register WHERE user_id = '$senderId'")->fetchAll()[0]["user"];
}

function getReceiverName($conn, $receiverId) {
  return $conn->query("SELECT user FROM register WHERE user_id = '$receiverId'")->fetchAll()[0]["user"];
}
	