<?php
/* 
 * Lazy Functions Library (lfl)
 */

/* 
 * Bevat code/functies die door het gehele systeem gedeeld worden
 * Gebruik altijd 
 * 
 * include_once "portfolio.php";
 * 
 * bij het aanmaken van een nieuwe PHP pagina voor de backend (login-, admin-, uploadpagina, etc.)
 * 
 * Functies in dit bestand beginnen met portfolio_
 */
//Includes
include_once "constants.php";

//Session start
session_start();

function lfl_connect()
{
    $link = @mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
    if($link !== false)
    {
        $db = @mysqli_select_db($link, DATABASE_NAME);
        if(!$db)
        {
            mysqli_close($link);
            $link = false;
        }
    }
    return $link;
}

function execute_sql_file($host, $user, $pass, $sqlfile)
{
    echo '<p>Executing sql file ' . $sqlfile . '</p>';
    if(file_exists($sqlfile))
    {
        $raw = readfile($sqlfile);
        $commands = explode(';', $raw);
        $link = @mysqli_connect($host, $user, $pass);
        if($link)
        {
            foreach($commands as $sql)
            {
                $result = mysqli_query($link, $sql);
                echo $result ? '<p>Executed query ' . $sql . ' with success.</p>' : '<p>ERROR: could not execute query ' . $sql . '</p>';
            }
            echo '<p>Finished executing sql file. Please check for errors above.</p>';
        }
        else
        {
            echo '<p>ERROR: could not connect to database!</p>';
        }
    }
    else
    {
        echo '<p>ERROR: file does not exist!</p>';
    }
}

/*
 * Haal de gebruikersgegevens van een gebruiker op aan de hand van het gebruikersId
 */
function lfl_get_user_details($userId)
{
    $userDetails = array();
    
    $link = lfl_connect();
    if($link)
    {
        $sql = "SELECT * FROM " . TABLE_USER . " WHERE userId=" . mysqli_real_escape_string($link, $userId);
        $result = mysqli_query($link, $sql);
        if($result !== false)
        {
            if(($array = mysqli_fetch_assoc($result)) != null)
            {
                $userDetails = $array;
                //je krijgt geen wachtwoord!
                $userDetails['password'] = null;
            }
            mysqli_free_result($result);
        }
    }
    
    return $userDetails;
}


/*
 * Probeer in te loggen en sla de gebruikersdata op in $_SESSION['user']
 */
function lfl_login($userName, $userPass)
{
    $userId = null;
    $link = lfl_connect();
    if($link)
    {
        $sql = "SELECT * FROM " . TABLE_USER . " WHERE username='" . mysqli_real_escape_string($link, $userName) . "'";
        $result = mysqli_query($link, $sql);
        if($result !== false)
        {
            if(($array = mysqli_fetch_assoc($result)) != null)
            {
                if(password_verify($userPass, $array['password']))
                {
                    $userId = $array['userId'];
                    $_SESSION['user'] = $array;
                    $_SESSION['user']['password'] = null;
                }
            }
            mysqli_free_result($result);
        }
    }
    return $userId;
}

function lfl_logout()
{
    if(isset($_SESSION['user']))
    {
        unset($_SESSION['user']);
    }
    return session_destroy();
}

/*
 * Registreer een gebruiker.
 */
function lfl_register($username, $password, $mail, $type = "user")
{
    $link = lfl_connect();
    if($link)
    {
        $sql = "SELECT userId FROM " . TABLE_USER . " WHERE username='" . mysqli_real_escape_string($link, $username) . "' OR mail='" . mysqli_real_escape_string($link, $mail) . "'";
        $result = mysqli_query($link, $sql);
        if(mysqli_fetch_assoc($result))
        {
            echo "<p>Username and/or email is already in use!</p>";
            return false;
        }
        $sql = "INSERT INTO " . TABLE_USER . " VALUES(NULL, "
                . "'" . mysqli_real_escape_string($link, $username) . "', "
                . "'" . mysqli_real_escape_string($link, password_hash($password, PASSWORD_DEFAULT)) . "', "
                . "'" . mysqli_real_escape_string($link, $mail) . "', "
                . "'" . mysqli_real_escape_string($link, $type) . "')";
        $result = mysqli_query($link, $sql);
        if($result)
        {
            return mysqli_insert_id($link);
        }
    }
    return false;
}


/*
 * Wijzig gebruiker
 * - Alleen voor ingelogde admin
 * - NULL parameters worden niet geupdate!
 */
function lfl_admin_update_user($userId, $username = null, $mail = null, $type = null)
{
    if(!lfl_user_is_of_type(array('admin')))
    {
        return null;
    }
    
    $link = lfl_connect();
    if($link)
    {
        $userData = lfl_get_user_details($userId);
        if($userData)
        {
            $gebruikersnaam = ($gebruikersnaam) ? $gebruikersnaam : $userData['username'];
            $email = ($email) ? $email : $userData['mail'];
            $rol = ($rol) ? $rol : $userData['type'];
            $sql = "UPDATE " . TABLE_USER . " SET "
                    . "gebruikersnaam='" . mysqli_real_escape_string($link, $gebruikersnaam) . "', "
                    . "mail='" . mysqli_real_escape_string($link, $email) . "', "
                    . "type='" . mysqli_real_escape_string($link, $rol)
                    . "' WHERE userId=" . mysqli_real_escape_string($link, $userId);
            $result = mysqli_query($link, $sql);
            return $result;
        }
    }
    
    return null;
}

function lfl_user_is_of_type($haystack = USER_TYPES)
{
    return (isset($_SESSION['user']) && in_array($_SESSION['user']['type'], $haystack));
}

function lfl_user_owns_list($userId, $listId)
{
    $link = lfl_connect();
    if($link)
    {
        $sql = "SELECT * 
            FROM list_user 
            WHERE list_user.listId=" . mysqli_real_escape_string($link, $listId)
            . " AND list_user.userId=" . mysqli_real_escape_string($link, $userId);
        $result = mysqli_query($link, $sql);
        if($result)
        {
            if(($row = mysqli_fetch_assoc($result)) != null)
            {
                return true;
            }
            mysqli_free_result($result);
        }
    }
    return null;
}

function lfl_get_list_users($listId)
{
    $link = lfl_connect();
    if($link)
    {
        $sql = "SELECT * 
            FROM list_user 
            WHERE list_user.listId=" . mysqli_real_escape_string($link, $listId);
        $result = mysqli_query($link, $sql);
        if($result)
        {
            $lists = array();
            while(($row = mysqli_fetch_assoc($result)) != null)
            {
                array_push($lists, $row);
            }
            mysqli_free_result($result);
            return $lists;
        }
    }
    return null;
}

function lfl_get_list($listId)
{
    $link = lfl_connect();
    if($link)
    {
        $sql = "SELECT * 
            FROM list 
            WHERE list.listId=" . mysqli_real_escape_string($link, $listId);
        $result = mysqli_query($link, $sql);
        if($result)
        {
            if(($row = mysqli_fetch_assoc($result)) != null)
            {
                return $row;
            }
            mysqli_free_result($result);
        }
    }
    return null;
}

function lfl_get_list_items($listId)
{
    $link = lfl_connect();
    if($link)
    {
        $sql = "SELECT * FROM item WHERE listId=" . mysqli_real_escape_string($link, $listId);
        $result = mysqli_query($link, $sql);
        if($result)
        {
            $lists = array();
            while(($row = mysqli_fetch_assoc($result)) != null)
            {
                array_push($lists, $row);
            }
            mysqli_free_result($result);
            return $lists;
        }
    }
    return null;
}

function lfl_get_user_lists($userId)
{
    $link = lfl_connect();
    if($link)
    {
        $sql = "SELECT list.listId AS listId, list.listname AS listname, list_user.isFav AS isFav 
            FROM list, list_user 
            WHERE list_user.userId=" . mysqli_real_escape_string($link, $userId) . " AND list.listId=list_user.listId";
        $result = mysqli_query($link, $sql);
        if($result)
        {
            $lists = array();
            while(($row = mysqli_fetch_assoc($result)) != null)
            {
                array_push($lists, $row);
            }
            mysqli_free_result($result);
            return $lists;
        }
    }
    return null;
}

function lfl_get_user_fav_lists($userId)
{
    $link = lfl_connect();
    if($link)
    {
        $sql = "SELECT list.listId AS listId, list.listname AS listname, list_user.isFav AS isFav 
            FROM list, list_user 
            WHERE list_user.userId=" . mysqli_real_escape_string($link, $userId) . " AND list.listId=list_user.listId AND list_user.isFav=TRUE";
        $result = mysqli_query($link, $sql);
        if($result)
        {
            $lists = array();
            while(($row = mysqli_fetch_assoc($result)) != null)
            {
                array_push($lists, $row);
            }
            mysqli_free_result($result);
            return $lists;
        }
    }
    return null;
}

/*
 * Tokens
 */
function lfl_token_update()
{
    if(lfl_user_is_of_type())
    {
        $_SESSION['user']['token'] = crypt((string)rand(0, PHP_INT_MAX), (string)rand(0, PHP_INT_MAX));
        return $_SESSION['user']['token'];
    }
    return false;
}

function lfl_token_verify($token)
{
    if(lfl_user_is_of_type())
    {
        return ($token === $_SESSION['user']['token']);
    }
    return false;
}

function lfl_add_list($ownerId, $listname)
{
    $link = lfl_connect();
    if($link)
    {
        $sql = "INSERT INTO list VALUES(NULL, '" . mysqli_real_escape_string($link, $listname) . "')";
        if(mysqli_query($link, $sql))
        {
            $id = mysqli_insert_id($link);
            $sql = "INSERT INTO list_user VALUES(" . $id . ", " . mysqli_real_escape_string($link, $ownerId) . ", 0)";
            if(mysqli_query($link, $sql))
            {
                return $id;
            }
        }
    }
    return null;
}

function lfl_toggle_list_fav($listId)
{
    $link = lfl_connect();
    if($link)
    {
        $lst = lfl_get_list($listId);
        if($lst)
        {
            $f = ($f > 0) ? 0 : 1;
            $sql = "UPDATE list SET isFav=" . $f . " WHERE listId=" . $listId;
            return mysqli_query($link, $sql);
        }
    }
    return null;
}