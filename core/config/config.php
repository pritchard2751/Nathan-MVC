<?php

define('DEBUG', true);
define('LOCAL', true);

//set error reporting level according to the development environment
if (DEBUG) {
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

if (DEBUG) {
    //settings for local database
    if (LOCAL) {
        define('DB_HOST', 'localhost:port');
        define('DB_USER', 'user');
        define('DB_USER_PASS', 'secret');
        define('DB_SCHEMA', 'name');
        define('DB_PREFIX', 'tbl_');
    }
    //settings for test server database
    else {
        define('DB_HOST', 'test.server.com');
        define('DB_USER', 'user');
        define('DB_USER_PASS', 'secret');
        define('DB_SCHEMA', 'name');
        define('DB_PREFIX', 'tbl_');
    }
}
//settings for production server database
else {
    define('DB_HOST', 'prod.server.com');
    define('DB_USER', 'user');
    define('DB_USER_PASS', 'secret');
    define('DB_SCHEMA', 'name');
    define('DB_PREFIX', 'tbl_');
}
