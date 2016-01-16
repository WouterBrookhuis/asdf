<div id="pageHeader">
    <div id="header">
        <h1>$_POST it</h1>
        <!--<form id="menuSearchDiv" action="#" method="get">
            <input id="menuSearchBox" type="text" name="searchField" placeholder="search">
            <input id="menuSearchIcon" type="image" src="images/icon-search.png" alt="submit">
        </form>-->
        <?php
        if(lfl_user_is_of_type())
        {
            echo '<div id="headerUserBox">';
            echo '<p>Logged in as</p><h3>' . $_SESSION['user']['username'] . '</h3>';
            echo '</div>';
        }
        ?>
    </div>
</div>
