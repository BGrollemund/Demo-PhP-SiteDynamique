<?php

$mysql = null;

function databaseGetConnection(): mysqli
{
    global $mysql;

    if( is_null( $mysql ) ) {
        $mysql = mysqli_connect( DB_HOST, DB_USER, DB_PASS, DB_NAME );
    }

    return $mysql;
}

function databaseClose(): void
{
    global $mysql;

    if( ! is_null( $mysql ) ) {
        mysqli_close( $mysql );
    }

    $mysql = null;
}