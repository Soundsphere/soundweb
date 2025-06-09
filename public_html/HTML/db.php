<?php
require_once 'config.php';

/**
 * Open a new database connection.
 *
 * @return mysqli
 */
function db_connect()
{
    $con = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_name']);
    if (mysqli_connect_errno()) {
        die('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
    return $con;
}

/**
 * Execute a prepared query and return the result set.
 *
 * @param mysqli  $con   The open connection
 * @param string  $sql   The SQL statement with placeholders
 * @param string  $types Parameter types for binding
 * @param array   $params Parameters to bind
 *
 * @return mysqli_result|false
 */
function db_query($con, $sql, $types = '', $params = [])
{
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) {
        die('Query prepare failed: ' . mysqli_error($con));
    }

    if ($types && !empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}

/**
 * Close an open database connection.
 */
function db_close($con)
{
    mysqli_close($con);
}
