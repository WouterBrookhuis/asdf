<?php
require 'lfl.php';
/*
 * Code voor de rest van de pagina zodat het menu klopt na inloggen
 */
$loggedIn = false;
$message = '';
if(isset($_POST["submit"]))
{
    $un = filter_input(INPUT_POST, 'userName');
    $pw = filter_input(INPUT_POST, 'userPass');
    if(!empty($un) && !empty($pw))
    {
        if(lfl_login($un, $pw))
        {
            $message = "<p>Welkom " . $_SESSION['user']['voornaam'] . " " . $_SESSION['user']['achternaam'] . "</p>\n";
            $loggedIn = true;
        }
        else
        {
            $message = "<p>Gebruikersnaam en/of wachtwoord niet correct!</p>\n";
        }
    }
    else
    {
        $message = "<p>Vul aub een gebruikersnaam en wachtwoord in</p>";
    }
}
?>
<!DOCTYPE html>
<!--
TODO:
- Pagina's toevoegen
- Content home toevoegen
- DB spul?
-->
<html>
    <head>
        <title>Rapunzel</title>
        <meta charset="UTF-8">
        <!-- Mobile phone 'support' -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="jquery-1.11.3.min.js"></script>
        <script src="menu.js"></script>
        <script src="header.js"></script>
    </head>
    <body>
        <?php 
        include 'inc/header.php';
        include 'inc/menu.php';
        ?>
        <div id="pageContent">
            <div id="content">
                <h1>Login</h1>
                <?php
                echo $message;
                if(!isset($_SESSION['user']))
                {
                    // put your code here
                    ?>
                    <p>Testaccounts</p>
                    <p>Zowel naam als wachtwoord:</p>
                    <p>docent, student, slb, admin</p>
                    <form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='post' enctype="multipart/form-data">
                        <p>Gebruikersnaam:<br><input type='text' name='userName'></p>
                        <p>Wachtwoord:<br><input type='password' name='userPass'></p>
                        <p><input type='submit' name='submit' value='login'></p>
                    </form>
                    <?php
                }
                else
                {
                    echo '<p>U bent al ingelogd als ' . $_SESSION['user']['voornaam'] . " " . $_SESSION['user']['achternaam'] . '</p>';
                    echo '<p><a href="admin.php">Ga terug</a></p>';
                }
                ?>
            </div>
        </div>
        <?php
        include 'inc/footer.php';
        ?>
    </body>
</html>
