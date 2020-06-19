<header>
    <nav class="navbar navbar-expand-lg navbar-custom text-light">
        <nav class="navbar navbar-custom">
            <a class="navbar-brand" href="#">
                <img src="../Images/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
                <span style="color:white">Online Chat Application</span>
            </a>
        </nav>

        <div class="collapse navbar-collapse navbar-dark" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link <?php if(!isset($_SESSION['id'])) echo "disabled";?>" href="ChatList.php"
                        style="color:white">My
                        Chats</a>
                </li>
            </ul>
            <div class="mr-sm-2">
                <?php
                if(isset($_SESSION['id'])) {
                    ?>
                <img src="<?= $_SESSION['url'] ?>" width="50" height="50" class="d-inline-block align-top" alt=""
                    id="user_image">
                <span class='navbar-text mr-5 text-white'> Welcome, <span><?=$_SESSION['name']?></span></span>
                <a href='Index.php' onclick='signOut();' style='color: inherit'>Logout</a>
                <?php
                }
                else {
                    echo "<a href=\"Index.php\">Login</a>";
                }
                ?>
            </div>
        </div>
    </nav>
</header>
