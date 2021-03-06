<?php

/* 
 * Constantes
 * ZET PORTFOLIO_DATABASE_MODE OP PORTFOLIO_MODE_SERVER VOOR UPLOAD NAAR SERVER!
 * 
 * NOOT: Voor PORTFOLIO_MODE_LOCAL is het nodig om een database te hebben op de localhost.
 * Zie de dropbox - Project -/SQL map voor de benodigde SQL scripts om dit op te zetten.
 */
//0 = lokaal, 1 = op server, php 'thuis', 2 = op server
define("DB_MODE_LOCAL", 0);
define("DB_MODE_SERVER_REMOTE", 1);
define("DB_MODE_SERVER", 2);

define("DB_DATABASE_MODE", DB_MODE_LOCAL);
if(DB_DATABASE_MODE === DB_MODE_LOCAL)
{
    define("DATABASE_NAME", "rapunzel");
    define("MYSQL_HOST", "localhost");
    define("MYSQL_PORT", ini_get("mysqli.default_port"));
    define("MYSQL_USER", "portfolio");
    define("MYSQL_PASS", "systeem");
}

define("TABLE_USER", "user");


define("UPLOAD_DIR", "files");
define("SITE_HTTP_NAME", "http://ons-portfolio.nl/");

const USER_TYPES = ['user', 'admin'];