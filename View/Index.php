<?php

?>
<html>

    <head>
        <?php include '../Includes/Header.php';?>
        <title>Login Authentication</title>
        <meta name="google-signin-client_id"
            content="975842725634-vv3rqdmmuflr5odhtd1u4c8jhffttood.apps.googleusercontent.com">
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet"
            id="bootstrap-css">
        <link rel="stylesheet" type="text/css" href="../Styles/Style_Header_Footer.css" />
        <link rel="stylesheet" type="text/css" href="../Styles/Style1.css" />
        <script type="text/javascript" src="../Scripts/Script.js"></script>
    </head>

    <body>
        <main id="index_main">
            <div id="googleLogin">
                <div class="g-signin2" id="signIn" data-onsuccess="onSignIn"></div>
            </div>
        </main>
        <?php include '../Includes/Footer.php';?>
    </body>

</html>
