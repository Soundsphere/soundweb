<?php
require_once __DIR__ . '/config.php';

/**
 * Open a new database connection.
 *
 * @return mysqli
 */
function db_connect()
{
    // PHP 8.1+ throws mysqli exceptions by default; make that explicit
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    try {
        return mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_name']);
    } catch (mysqli_sql_exception $ex) {
        error_log('Failed to connect to MySQL: ' . $ex->getMessage());
        die('Database unavailable.');
    }
}

/**
 * Execute a prepared query and return the result set.
 *
 * @param mysqli  $con   The open connection
 * @param string  $sql   The SQL statement with placeholders
 * @param string  $types Parameter types for binding
 * @param array   $params Parameters to bind
 *
 * @return mysqli_result
 */
function db_query($con, $sql, $types = '', $params = [])
{
    try {
        $stmt = mysqli_prepare($con, $sql);

        if ($types && !empty($params)) {
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
    } catch (mysqli_sql_exception $ex) {
        error_log('Query failed: ' . $ex->getMessage());
        die('Database error.');
    }

    return $result;
}

/**
 * Close an open database connection.
 */
function db_close($con)
{
    mysqli_close($con);
}
