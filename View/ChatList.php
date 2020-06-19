<?php
session_start();
include '../XML/UsersXML.php';
include '../XML/ChatXML.php';

//If session is not set go back to login page.
if(!isset($_SESSION['id']))
{
    header("location:Index.php");
}

//When a new user is added to the chat
if(isset($_POST['addConversation']))
{
    $chat = new ChatXML();
    $chat->createConversation($_SESSION['id'],$_POST['newUser']);
}

//When a new message is added
if(isset($_POST['newMessage']))
{
    $chat = new ChatXML();
    error_log($_SESSION['id']);
    error_log($_POST['receiverId']);
    error_log($_POST['message']);
}

//Getting the list of users
$users = new UsersXML();
$userList = $users->userList();


//Getting the list of chats
$chat = new ChatXML();
$chats = $chat->chatList($_SESSION['id']);
error_log("Entering log");

?>
<html>

    <head>
        <?php include '../Includes/Header.php';?>
        <title>Chat List</title>
        <meta name="google-signin-client_id"
            content="975842725634-vv3rqdmmuflr5odhtd1u4c8jhffttood.apps.googleusercontent.com">
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet"
            id="bootstrap-css">
        <link rel="stylesheet" type="text/css" href="../Styles/Style_Header_Footer.css" />
        <link rel="stylesheet" type="text/css" href="../Styles/Style1.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
            integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        <script type="text/javascript" src="../Scripts/Script.js"></script>

        <script type="text/javascript"
            src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    </head>

    <body>
        <main id="chat_main">
            <section id="section1">
                <div id="google_translate_element"></div>

                <div class="container-fluid h-100">
                    <div class="row justify-content-center h-100">
                        <div class="col-md-4 col-xl-3 chat">
                            <div class="card mb-sm-3 mb-md-0 contacts_card">
                                <div class="card-header">
                                    <div class="input-group">
                                        <form method="post" action="#">
                                            <select name="newUser" class="form-control search" style="width:275px">
                                                <?php
                                                foreach ($userList as $user)
                                                {
                                                    error_log($user->getElementsByTagName("firstname")[0]->nodeValue);
                                                    $flag = 0;
                                                    //If user is the logged in user he will not be added to the dropdown list
                                                    if($user->getElementsByTagName("id")[0]->nodeValue != $_SESSION['id'])
                                                    {
                                                        //If logged in user has a chat already with another user, he will not be shown in the drop down.
                                                        foreach ($chats as $chat) {
                                                            if(($chat->getAttribute("user1")==$_SESSION['id']&& $chat->getAttribute("user2")==$user->getElementsByTagName("id")[0]->nodeValue) || ($chat->getAttribute("user2")==$_SESSION['id']&& $chat->getAttribute("user1")==$user->getElementsByTagName("id")[0]->nodeValue ))
                                                            {
                                                                $flag=1;
                                                            }
                                                        }
                                                        if($flag==0){
                                                        ?>
                                                <option value="<?= $user->getElementsByTagName("id")[0]->nodeValue ?>">
                                                    <?= $user->getElementsByTagName("email")[0]->nodeValue ?></option>
                                                <?php
                                                        }
                                                    }
                                                }
                                            ?>
                                            </select>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-body contacts_body">
                                    <ul class="contacts">
                                        <!--Code to show the list of chats of the user-->
                                        <?php foreach ($chats as $chat)
                                            {
                                            if($chat->getAttribute("user1")!=$_SESSION['id']) {
                                                $user=$users->getUser($chat->getAttribute("user1"));
                                            }
                                            else
                                            {
                                                $user=$users->getUser($chat->getAttribute("user2"));
                                            }
                                            ?>
                                        <li class="chat_user">
                                            <div id="user1" style="display: none">
                                                <?=$_SESSION['id']?>
                                            </div>
                                            <div id="user2" style="display: none">
                                                <?php
                                                    if($_SESSION['id']==$chat->getAttribute("user1")){
                                                        echo $chat->getAttribute("user2");
                                                    }
                                                    else
                                                    {
                                                        echo $chat->getAttribute("user1");
                                                    }?>
                                            </div>
                                            <div id="chatImage">
                                                <div id="name" style="display: none">
                                                    <?= $user->getElementsByTagName("firstname")[0]->nodeValue?>
                                                </div>
                                                <div id="image1" style="display: none"><?= $_SESSION['url']?>
                                                </div>
                                                <div id="image2" style="display: none">
                                                    <?= $user->getElementsByTagName("url")[0]->nodeValue?>
                                                </div>
                                            </div>

                                            <div class="d-flex bd-highlight">
                                                <div class="img_cont">
                                                    <img src="<?= $user->getElementsByTagName("url")[0]->nodeValue ?>"
                                                        class="rounded-circle user_img">
                                                    <!-- <span class="online_icon"></span> -->
                                                </div>
                                                <div class="user_info">
                                                    <span><?= $user->getElementsByTagName("firstname")[0]->nodeValue; ?></span>
                                                </div>
                                            </div>
                                        </li>
                                        <?php
                                            }
                                        ?>
                                    </ul>
                                </div>
                                <div class="card-footer">

                                </div>
                            </div>
                        </div>

                        <div class="col-md-8 col-xl-6 chat">
                            <div class="card">
                                <!-- Chat Heading -->
                                <div class="class-header msg_head">
                                    <div class="d-flex bd-highlight">
                                        <div class="img_cont" id="header_image">
                                            <!-- Image goes here -->
                                            <span class="online_icon"></span>
                                        </div>
                                        <div class="user_info" id="header_name">
                                            <!-- <p>Number of messages goes over here</p> -->
                                        </div>
                                    </div>
                                </div>
                                <!-- Chat Body -->
                                <div class="card-body msg_card_body" id="messageBody">
                                    <!-- Chat Messages -->
                                </div>
                                <div class="card-footer">
                                    <form onsubmit="return false;">
                                        <div id="receiverId"></div>
                                        <div class="input-group">
                                            <!-- <textarea name="" class="form-control type_msg"
                                                placeholder="Type your message..." name="message" id="message">
                                            </textarea>
                                            <div class="input-group-append">
                                                <span class="input-group-text send_btn">
                                                    <button type="submit" name="newMessage" id="sendButton"><i
                                                            class="fas fa-location-arrow" style="color:white;"></i>
                                                    </button>
                                                </span>
                                            </div> -->
                                            <input type="text" class="form-control type_msg" name="message" id="message"
                                                placeholder="Type a message" autocomplete="off">
                                            <button type="submit" class="input-group-text send_btn" name="newMessage"
                                                id="sendButton"><i class="fas fa-location-arrow pr-1"></i> </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
            </section>
        </main>
        <?php include '../Includes/Footer.php';?>
    </body>

</html>
