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
            else
            {
                echo '<li class="menuLi"><a href="logout.php">Logout</a></li>';
            }
            ?>
            <!-- TODO: Showcase gaat naar eerste child -->
            <li id="li_showcase" class="menuLi"><a href="portfolio-systeem.php">Showcase</a>
                <ul class="showcaseMenuUl">
                    <li class="showcaseMenuLi"><a href="portfolio-systeem.php">Portfolio Systeem</a></li>
                    <!--<li class="showcaseMenuLi"><a href="#">Item 3</a></li>-->
                </ul>
            </li>
        </ul>
    </div>
</div>