<?php

    define('DB_SERVER', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=127.0.0.1)(PORT=1521))(CONNECT_DATA=(SERVICE_NAME=XE)))');
    define('DB_USERNAME', 'anassamii');
    define('DB_PASSWORD', 'anas123');
    define('DB_NAME', 'XE');

    try{
        $link = new PDO("oci:dbname=".DB_SERVER,DB_USERNAME,DB_PASSWORD);
    } catch (PDOException $e) {
        echo ($e->getMessage());
    }
