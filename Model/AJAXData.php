<?php

include '../XML/UsersXML.php';
include '../XML/ChatXML.php';

//Getting the Data from the AJAX jQuery API and se
if(isset($_POST['id']))
{
    $id = $_POST['id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $url = $_POST['url'];
    $email = $_POST['email'];

    session_start();
    $_SESSION['id'] = $id;
    $_SESSION['name'] = $firstName;
    $_SESSION['url'] = $url;

    $userXML = new UsersXML();
    $userXML->addUser($id,$firstName,$lastName,$url,$email);

}

//Adding a new message
if(isset($_POST['message']))
{
    error_log("Adding new message");

    $user1 = $_POST['user1'];
    $user2 = $_POST['user2'];
    $message = $_POST['message'];

    error_log("User1:".$user1);
    error_log("User2:".$user2);
    error_log("Message:".$message);

    $chatXML = new ChatXML();
    $chatXML->addMessage($user1,$user2,$message);

}

//Destroying sessions while signing out.
if(isset($_POST['signOut']))
{
    error_log("Post: Signout");
    session_start();
    session_destroy();
}

?>