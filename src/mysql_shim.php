<?php
/**
 * MySQL Compatibility Shim for PHP 7.0+ / PHP 8.x
 * 
 * This file provides wrapper functions that map deprecated mysql_* functions
 * to their mysqli equivalents, allowing legacy code to run on modern PHP.
 * 
 * Include this file BEFORE any database operations.
 */

// Global mysqli connection object
$GLOBALS['__mysql_shim_link'] = null;

/**
 * Connect to MySQL database (maps mysql_connect to mysqli_connect)
 */
if (!function_exists('mysql_connect')) {
    function mysql_connect($server = null, $username = null, $password = null) {
        $link = mysqli_connect($server, $username, $password);
        if ($link) {
            $GLOBALS['__mysql_shim_link'] = $link;
        }
        return $link;
    }
}

/**
 * Select database (maps mysql_select_db to mysqli_select_db)
 */
if (!function_exists('mysql_select_db')) {
    function mysql_select_db($database_name, $link = null) {
        $link = $link ?: $GLOBALS['__mysql_shim_link'];
        return mysqli_select_db($link, $database_name);
    }
}

/**
 * Execute query (maps mysql_query to mysqli_query)
 */
if (!function_exists('mysql_query')) {
    function mysql_query($query, $link = null) {
        $link = $link ?: $GLOBALS['__mysql_shim_link'];
        if (!$link) {
            trigger_error('mysql_query(): No connection to MySQL server', E_USER_WARNING);
            return false;
        }
        return mysqli_query($link, $query);
    }
}

/**
 * Fetch row as array (maps mysql_fetch_array to mysqli_fetch_array)
 */
if (!function_exists('mysql_fetch_array')) {
    function mysql_fetch_array($result, $result_type = MYSQLI_BOTH) {
        if (!$result) return null;
        return mysqli_fetch_array($result, $result_type);
    }
}

/**
 * Fetch row as associative array (maps mysql_fetch_assoc to mysqli_fetch_assoc)
 */
if (!function_exists('mysql_fetch_assoc')) {
    function mysql_fetch_assoc($result) {
        if (!$result) return null;
        return mysqli_fetch_assoc($result);
    }
}

/**
 * Fetch row as object (maps mysql_fetch_object to mysqli_fetch_object)
 */
if (!function_exists('mysql_fetch_object')) {
    function mysql_fetch_object($result, $class_name = 'stdClass', $params = null) {
        if (!$result) return null;
        return mysqli_fetch_object($result, $class_name, $params ?: []);
    }
}

/**
 * Fetch row as numeric array (maps mysql_fetch_row to mysqli_fetch_row)
 */
if (!function_exists('mysql_fetch_row')) {
    function mysql_fetch_row($result) {
        if (!$result) return null;
        return mysqli_fetch_row($result);
    }
}

/**
 * Get number of rows (maps mysql_num_rows to mysqli_num_rows)
 */
if (!function_exists('mysql_num_rows')) {
    function mysql_num_rows($result) {
        if (!$result) return 0;
        return mysqli_num_rows($result);
    }
}

/**
 * Get number of affected rows (maps mysql_affected_rows to mysqli_affected_rows)
 */
if (!function_exists('mysql_affected_rows')) {
    function mysql_affected_rows($link = null) {
        $link = $link ?: $GLOBALS['__mysql_shim_link'];
        return mysqli_affected_rows($link);
    }
}

/**
 * Get last insert ID (maps mysql_insert_id to mysqli_insert_id)
 */
if (!function_exists('mysql_insert_id')) {
    function mysql_insert_id($link = null) {
        $link = $link ?: $GLOBALS['__mysql_shim_link'];
        return mysqli_insert_id($link);
    }
}

/**
 * Escape string (maps mysql_real_escape_string to mysqli_real_escape_string)
 */
if (!function_exists('mysql_real_escape_string')) {
    function mysql_real_escape_string($string, $link = null) {
        $link = $link ?: $GLOBALS['__mysql_shim_link'];
        if (!$link) {
            // Fallback if no connection
            return addslashes($string);
        }
        return mysqli_real_escape_string($link, $string);
    }
}

/**
 * Escape string (maps mysql_escape_string - deprecated even before removal)
 */
if (!function_exists('mysql_escape_string')) {
    function mysql_escape_string($string) {
        return mysql_real_escape_string($string);
    }
}

/**
 * Free result memory (maps mysql_free_result to mysqli_free_result)
 */
if (!function_exists('mysql_free_result')) {
    function mysql_free_result($result) {
        if ($result) {
            return mysqli_free_result($result);
        }
        return false;
    }
}

/**
 * Get MySQL error message (maps mysql_error to mysqli_error)
 */
if (!function_exists('mysql_error')) {
    function mysql_error($link = null) {
        $link = $link ?: $GLOBALS['__mysql_shim_link'];
        if (!$link) return '';
        return mysqli_error($link);
    }
}

/**
 * Get MySQL error number (maps mysql_errno to mysqli_errno)
 */
if (!function_exists('mysql_errno')) {
    function mysql_errno($link = null) {
        $link = $link ?: $GLOBALS['__mysql_shim_link'];
        if (!$link) return 0;
        return mysqli_errno($link);
    }
}

/**
 * Close connection (maps mysql_close to mysqli_close)
 */
if (!function_exists('mysql_close')) {
    function mysql_close($link = null) {
        $link = $link ?: $GLOBALS['__mysql_shim_link'];
        if ($link) {
            $result = mysqli_close($link);
            if ($link === $GLOBALS['__mysql_shim_link']) {
                $GLOBALS['__mysql_shim_link'] = null;
            }
            return $result;
        }
        return false;
    }
}

/**
 * Get result data (maps mysql_result - complex, partial implementation)
 */
if (!function_exists('mysql_result')) {
    function mysql_result($result, $row, $field = 0) {
        if (!$result) return false;
        mysqli_data_seek($result, $row);
        $data = mysqli_fetch_array($result);
        if (is_string($field)) {
            return $data[$field] ?? false;
        }
        return $data[$field] ?? false;
    }
}

/**
 * Get number of fields (maps mysql_num_fields to mysqli_num_fields)
 */
if (!function_exists('mysql_num_fields')) {
    function mysql_num_fields($result) {
        if (!$result) return 0;
        return mysqli_num_fields($result);
    }
}

/**
 * Data seek (maps mysql_data_seek to mysqli_data_seek)
 */
if (!function_exists('mysql_data_seek')) {
    function mysql_data_seek($result, $row_number) {
        if (!$result) return false;
        return mysqli_data_seek($result, $row_number);
    }
}

/**
 * Ping connection (maps mysql_ping to mysqli_ping)
 */
if (!function_exists('mysql_ping')) {
    function mysql_ping($link = null) {
        $link = $link ?: $GLOBALS['__mysql_shim_link'];
        if (!$link) return false;
        return mysqli_ping($link);
    }
}

/**
 * Get client info (maps mysql_get_client_info to mysqli_get_client_info)
 */
if (!function_exists('mysql_get_client_info')) {
    function mysql_get_client_info() {
        return mysqli_get_client_info();
    }
}

/**
 * Get server info (maps mysql_get_server_info to mysqli_get_server_info)
 */
if (!function_exists('mysql_get_server_info')) {
    function mysql_get_server_info($link = null) {
        $link = $link ?: $GLOBALS['__mysql_shim_link'];
        if (!$link) return '';
        return mysqli_get_server_info($link);
    }
}

?>
