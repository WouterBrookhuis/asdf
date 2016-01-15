<div id="pageMenuFake"></div>
<div id="pageMenu">
    <div id="menu">
        <ul id="menuUl">
            <li class="menuLi"><a href="index.php">Home</a></li>
            <?php
            if(!lfl_user_is_of_type())
            {
                echo '<li class="menuLi"><a href="login.php">Login</a></li>';
            }
            else//Logged in
            {
                echo '<li class="menuLi"><a href="logout.php">Logout</a></li>';
                ?>
                <li id="li_showcase" class="menuLi"><a href="lists.php">Lists</a>
                    <ul class="showcaseMenuUl">
                        <?php
                        $favs = lfl_get_user_fav_lists($_SESSION['user']['userId']);
                        foreach($favs as $entry)
                        {
                            echo '<li class="showcaseMenuLi"><a href="viewlist.php?list=' . $entry['listId'] . '">' . $entry['listname'] . '</a></li>';
                        }
                        ?>
                        <li class="showcaseMenuLi"><a href="newlist.php">... new list</a></li>
                    </ul>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
</div>