<?php
    ob_start();
    session_start();

    $timezone = date_default_timezone_set("America/New_York");

    $db['db_host'] = 'localhost';
    $db['db_user'] = 'root' ;
    $db['db_password'] = '';
    $db['db_name'] = '';


    foreach($db as $key => $value){

        define(strtoupper($key), $value);

        $DB[$key] = $value;
    }

    $connection = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME );

    if(mysqli_connect_errno()){
        echo "Failed to connect: " . mysqli_connect_error();
    }

?>