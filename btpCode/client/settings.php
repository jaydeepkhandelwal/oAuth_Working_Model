<?php
$server_dir_name = "server";
$server_request_token_file_name = "request_token.php";
$server_api_file_name = "api.php";
$server_access_token_file_name = "access_token.php";
$server_login_file_name = "login.php";
$client_dir_name = "client";
$client_callback_file_name = "callback.php";
$client_api_file_name = "apicall.php";

$host_url = "http://localhost";
$file_path= $_SERVER["PHP_SELF"];
$dir = dirname($file_path);
$parent_dir = dirname($dir);

?>
