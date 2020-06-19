<?php


class ChatXML
{
    function createConversation($user1,$user2){
        $userDoc = new DOMDocument('1.0', "utf-8");
        $userDoc->load("../XML/Chat.xml");
        $chat = $userDoc->getElementsByTagName("chat")[0];

        $chats = $userDoc->getElementsByTagName("conversation");
        foreach ($chats as $c)
        {
            if($c->getAttribute("user1")==$user1 && $c->getAttribute("user2")==$user2 || $c->getAttribute("user2")==$user1 && $c->getAttribute("user1")==$user2){
                return;
            }
        }
        $conversation = $userDoc->createElement("conversation");
        $conversation->setAttribute("user1",$user1);
        $conversation->setAttribute("user2",$user2);

        $chat->appendChild($conversation);
        $userDoc->save("../XML/Chat.xml");
    }

    function chatList($user){
        $userDoc = new DOMDocument('1.0', "utf-8");
        $userDoc->load("../XML/Chat.xml");
        $chats = $userDoc->getElementsByTagName("conversation");
        $chatList =  array();
        foreach ($chats as $chat){
            if($chat->getAttribute("user1") == $user || $chat->getAttribute("user2") == $user)
            {
                array_push($chatList,$chat);
            }
        }
        return $chatList;
    }

    function getChat($user1,$user2){
        error_log("Getting Chat");
        $userDoc = new DOMDocument('1.0', "utf-8");
        $userDoc->load("../XML/Chat.xml");
        $conversations = $userDoc->getElementsByTagName("conversation");
        foreach ($conversations as $conversation) {
            if($conversation->getAttribute("user1") == $user1 && $conversation->getAttribute("user2")==$user2 || $conversation->getAttribute("user2") == $user1 && $conversation->getAttribute("user1")==$user2) {
                error_log("Found User");
                return $conversation;
            }
        }
        return;
    }

    function addMessage($user1,$user2,$message){
        error_log("Adding a new message");
        $userDoc = new DOMDocument('1.0', "utf-8");
        $userDoc->load("../XML/Chat.xml");
        $chats = $userDoc->getElementsByTagName("conversation");
        foreach ($chats as $chat){
            error_log("User1: ".$user1);
            error_log("User2: ".$user2);
            if($chat->getAttribute("user1") == $user1 && $chat->getAttribute("user2")==$user2 || $chat->getAttribute("user2") == $user1 && $chat->getAttribute("user1")==$user2) {
                error_log("Found user");
                $message = $userDoc->createElement("message",$message);
                $message->setAttribute("user",$user1);

                $chat->appendChild($message);
                $userDoc->save("../XML/Chat.xml");
            }
        }
    }
}