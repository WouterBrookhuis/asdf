<?php
require 'lfl.php';
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
        <title>Register - POST it</title>
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
                <h1>Register</h1>
                <?php
                if(isset($_POST['submit']))
                {
                    $gebruikersnaam = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
                    $wachtwoord = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
                    $mail = filter_input(INPUT_POST, 'mail', FILTER_VALIDATE_EMAIL);
                    if($gebruikersnaam && $wachtwoord && $mail)
                    {
                        if(strlen($gebruikersnaam) > 30
                                || strlen($mail) > 50)
                        {
                            echo '<p>Username (' . strlen($gebruikersnaam) . '/30) or email (' . strlen($mail) . '/50) too long</p>';
                        }
                        else
                        {
                            $id = lfl_register($gebruikersnaam, $wachtwoord, $mail);
                            if($id)
                            {
                                echo '<p>User registered</p>';
                            }
                            else
                            {
                                echo '<p>Could not register user</p>';
                            }
                        }
                    }
                    else
                    {
                        echo '<p>Not all fields are filled in correctly</p>';
                    }
                }

                ?>
            <form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='post'>
                <p>Username:<br><input type='text' name='username'></p>
                <p>Password:<br><input type='password' name='password'></p>
                <p>Email:<br><input type='text' name='mail'></p>
                <p><input type='submit' name='submit' value='Register'></p>
            </form>
            </div>
        </div>
        <?php
        include 'inc/footer.php';
        ?>
    </body>
</html>
