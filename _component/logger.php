<?php
define('WP_LOGGER_DIR', WP_PLUGIN_DIR . '/' . IV_PLUGIN_NAME . '/_log');

/**
 * trace logging
 */
function iv_trace_log($message) {
    iv_pring_log('trace.log', iv_construct_log($message));
}

/**
 * logging formatter
 */
function iv_construct_log($message) {
    $ip = getEnv('REMOTE_ADDR');
    $ip = ($ip=='')?'none':"$ip";
    $date = date('Y/m/d H:i:s', time());
    if (is_object($message)||is_array($message)) {
        $message = var_export($message, true);
    }
    return "[$date][$ip]$message";
}

function iv_pring_log($file, $str) {
    $path = WP_LOGGER_DIR . '/' . $file;
    $fp = fopen($path, "a+");
    fwrite($fp, $str . "\n");
    fclose($fp);
}
