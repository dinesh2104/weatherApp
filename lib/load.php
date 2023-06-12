<?php
global $__site_config;

include_once $_SERVER['DOCUMENT_ROOT'] . '/PhpSdk/PlayFabSDK/PlayFabHttp.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/PhpSdk/PlayFabSDK/PlayFabClientApi.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/PhpSdk/PlayFabSDK/PlayFabAuthenticationApi.php';

function customAutoLoader($class)
{
    $file1 = __DIR__ . '/includes/' . $class . '.class.php';
    $file2 = __DIR__ . '/app/' . $class . '.class.php';
    if (file_exists($file1)) {
        include_once $file1;
    } else if (file_exists($file2)) {
        include_once $file2;
    }
}

spl_autoload_register('customAutoLoader');

Session::start();

$__site_config_path = __DIR__ . '/../../config.json';
$__site_config = file_get_contents($__site_config_path);

function get_config($key, $default = null)
{
    global $__site_config;
    $array = json_decode($__site_config, true);
    if (isset($array[$key])) {
        return $array[$key];
    } else {
        return $default;
    }
}

function removechar($res)
{
    $res = str_replace(array('\'', '"', ',', ';', '<', '>'), '', $res);
    return $res;
}
