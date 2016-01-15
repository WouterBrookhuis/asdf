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
                <?php
                    if(lfl_user_is_of_type())
                    {
                        $userLists = lfl_get_user_lists($_SESSION['user']['userId']);
                        if(count($userLists) > 0)
                        {
                            echo '<table class="listsTable">';
                            echo '<tr><th class="col_80" rel="col">List name</th><th class="col_20" rel="col"></th></tr>';
                            foreach($userLists as $list)
                            {
                                echo '<tr>';
                                echo '<td class="col_80">' . $list['listname'] . '</td>';
                                $src = $list['isFav'] ? 'img/icon-star-checked.png' : 'img/icon-star-unchecked.png';
                                echo '<td class="col_20"><img class="icon_small" id="fav_' . $list['listId'] . '" alt="star" src="' . $src . '"></td>';
                                echo '</tr>';
                            }
                            echo '</table>';
                        }
                        else
                        {
                            echo '<p>Create your first list</p>';
                        }
                    }
                    else
                    {
                        echo '<p>You have to be <a href="login.php">logged in</a> to visit this page</p>';
                    }
                ?>
            </div>
        </div>
        <?php
        include 'inc/footer.php';
        ?>
    </body>
</html>
