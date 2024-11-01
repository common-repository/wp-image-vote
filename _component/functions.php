<?php
/**
 * デバッグ用関数
 */
if (!function_exists('a')) {
    function a() {
        if (!class_exists('dBug', false)) {
            require_once(WP_PLUGIN_DIR . '/wp-image-vote\_component/debug/dBug.php');
        }
        foreach (func_get_args() as $v) new dBug($v);
    }
}

function __e($str) {
    _e($str, IV_DOMAIN);
}

function __v($str) {
    return __($str, IV_DOMAIN);
}

if (!function_exists('unicode_decode')) {
    function unicode_decode($str) {
      return preg_replace_callback("/((?:[^\x09\x0A\x0D\x20-\x7E]{3})+)/", "decode_callback", $str);
    }
}

if (!function_exists('unicode_encode')) {
    function unicode_encode($str) {
      return preg_replace_callback("/\\\\u([0-9a-zA-Z]{4})/", "encode_callback", $str);
    }
}

function decode_callback($matches) {
  $char = mb_convert_encoding($matches[1], "UTF-16", "UTF-8");
  $escaped = "";
  for ($i = 0, $l = strlen($char); $i < $l; $i += 2) {
    $escaped .=  "\u" . sprintf("%02x%02x", ord($char[$i]), ord($char[$i+1]));
  }
  return $escaped;
}

function encode_callback($matches) {
  $char = mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UTF-16");
  return $char;
}

function null2br($str) {
    if (is_null(trim($str)) || !isset($str) || $str == '') {
        $str = '<br/>';
    }
    return $str;
}
