<?php
require 'lfl.php';
$logout = lfl_logout();
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
                <h1>Logout</h1>
                <?php
                if($logout)
                {
                    echo '<p>U bent uitgelogd</p>';
                    echo '<p><a href="index.php">Ga terug naar de homepage</a></p>';
                }
                else
                {
                    echo '<p>Er ging iets mis! Probeer het nog eens</p>';
                }
                ?>
            </div>
        </div>
        <?php
        include 'inc/footer.php';
        ?>
    </body>
</html>
