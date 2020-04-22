<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

require "../../src/database/UsersDB.php";
require "../../src/UserManager.php";

$conversations = array();

try {
    $conn = UsersDB::newInstance();
    $userId = UserManager::retrieveUserId();
    
    if ($userId == UserManager::NO_USER) {
        exit();
    }
    $newMessagesRows = getNewMessages($conn, $userId);
    $messagesRows = getMessages($conn, $userId);
    
    foreach ($messagesRows as $messageRow) {
        $message = getMessage($messageRow, $conn, $userId);
        $conversationItem = $message["ci"];
        $messageObject = $message["message"];
        
        if (!isset($conversations[$conversationItem])) {
            $conversations[$conversationItem] = array();
            $conversations[$conversationItem]["unread"] = false;
            $conversations[$conversationItem]["messages"] = array();
        }
        $conversation = &$conversations[$conversationItem];
        $conversation["messages"][] = $messageObject;
        
        if (in_array($messageObject->sender, $newMessagesRows)) {
            $conversation["unread"] = true;
        }
    }
}
catch (PDOException $e) {
    header("Content-Type: application/json;charset=utf-8");
    echo json_encode([$e]);
    exit();
}
header("Content-Type: application/json;charset=utf-8");
echo json_encode($conversations);

function getNewMessages($conn, $userId) {
    $query = "SELECT new_messages FROM user_data WHERE user_id = '$userId'";
    $result = $conn->query($query);
    $userNM = $result->fetchAll()[0]["new_messages"];
    
    return json_decode($userNM, true);
}

function getMessages($conn, $userId) {
    $query = "
    SELECT sender, receiver, date, message
    FROM messages
    WHERE receiver = '$userId'
    OR sender = '$userId'";
    $result = $conn->query($query);
    return $result->fetchAll();
}

function getMessage($messageRow, $conn, $userId) {
    $message = new stdClass();
    $message->sender = $messageRow["sender"];
    $message->receiver = $messageRow["receiver"];
    $message->date = $messageRow["date"];
    $message->message = $messageRow["message"];
    
    $senderName = ($message->sender != $userId) ? getSenderName($conn, $message->sender) : null;
    $receiverName = ($message->receiver != $userId) ? getReceiverName($conn, $message->receiver) : null;
    $conversationItem = ($senderName != null) ? $senderName : $receiverName;
    $messageType = ($senderName != null) ? "input" : "output";
    $message->messageType = $messageType;
    return ["ci" => $conversationItem, "message" => $message];
}

function getSenderName($conn, $senderId) {
    if ($senderId == 0) {
        return "SGC Learning";
    }
    return $conn->query("SELECT user FROM register WHERE user_id = '$senderId'")->fetchAll()[0]["user"];
}

function getReceiverName($conn, $receiverId) {
    return $conn->query("SELECT user FROM register WHERE user_id = '$receiverId'")->fetchAll()[0]["user"];
}
	