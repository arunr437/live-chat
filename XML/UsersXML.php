<?php


class UsersXML
{
    function addUser($id,$firstName,$lastName,$url,$email)
    {

        //Check if user already exists
        $userExists = false;
        $userDoc = new DOMDocument('1.0', "utf-8");
        $userDoc->load("../XML/Users.xml");
        $users = $userDoc->getElementsByTagName("user");

        foreach ($users as $user)
        {
            if($user->getElementsByTagName("id")[0]->nodeValue == $id)
            {
                error_log("User already exists");
                $userExists = true;
                break;
            }
        }

        //If user does not exist create new user
        if($userExists==false)
        {
            error_log("User does not exist. Adding new user");
            $user = $userDoc->createElement("user");
            $user->setAttribute("type","Client");
            $id = $userDoc->createElement("id",$id);
            $name = $userDoc->createElement("name");
            $firstName = $userDoc->createElement("firstname",$firstName);
            $lastName = $userDoc->createElement("lastname",$lastName);
            $name->appendChild($firstName);
            $name->appendChild($lastName);
            $url = $userDoc->createElement("url",$url);
            $email = $userDoc->createElement("email",$email);
            $user->appendChild($id);
            $user->appendChild($name);
            $user->appendChild($url);
            $user->appendChild($email);
            $users = $userDoc->getElementsByTagName('users')[0];
            $users->appendChild($user);
            $userDoc->save("../XML/Users.xml");
        }
    }

    function userList(){
        $userDoc = new DOMDocument('1.0', "utf-8");
        $userDoc->load("../XML/Users.xml");
        return $userDoc->getElementsByTagName("user");
    }

    function getUser($userId){
        $userDoc = new DOMDocument('1.0', "utf-8");
        $userDoc->load("../XML/Users.xml");
        $users = $userDoc->getElementsByTagName("user");
        foreach ($users as $user) {
            if($user->getElementsByTagName("id")[0]->nodeValue == $userId)
                return $user;
        }
        return;
    }
}