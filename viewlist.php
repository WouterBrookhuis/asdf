<?php
require 'lfl.php';
if(lfl_user_is_of_type()){
    $listId = filter_input(INPUT_GET, 'listId');
    $listData = null;
    $userOwnsList = false;
    if($listId){
        $listData = lfl_get_list($listId);
        $userOwnsList = lfl_user_owns_list($_SESSION['user']['userId'], $listId);
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
        <title><?php echo '' ?> - POST it</title>
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
                    if(lfl_user_is_of_type()){
                        if($userOwnsList || lfl_user_is_of_type(array('admin'))){
                            if($listData){
                                //Dump dat shit jo
                                echo '<h2>Viewing: ' . $listData['listname'] . '</h2>' . "\n";
                                
                                $items = lfl_get_list_items($listId);
                                foreach($items as $item){
                echo '<div class="listItemBox">';
                    echo '<div class="listItemBoxHeader">';
                        echo '<h3>' . $item['itemname'] . '</h3>';
                    echo '</div>';
                    echo '<div class="listItemBoxContent">';
                        echo '<p>' . $item['itemtext'] . '</p>';
                    echo '</div>';
                echo '</div>' . "\n";
                                }
                            }else{
                                echo '<p>List not found</p>';
                            }
                        }else{
                            echo '<p>You are not allowed to see this list</p>';
                        }
                    }else{
                        echo '<p>This page is only available to logged in users</p>';
                    }
                ?>
            </div>
        </div>
        <?php
        include 'inc/footer.php';
        ?>
    </body>
</html>
