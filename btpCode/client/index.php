<?php
		require_once("settings.php");
	
		$server_request_token_file_addr = "/".$server_dir_name."/".$server_request_token_file_name;
		$client_callback_file_addr = "/".$client_dir_name."/".$client_callback_file_name;
		$server_url_for_request_token = $host_url.$parent_dir.$server_request_token_file_addr;
		$client_callback_url = $host_url.$parent_dir.$client_callback_file_addr;
		$request_url = $server_url_for_request_token."?oauth_callback=".$client_callback_url;
		$client = new Oauth("key","secret");
		
		$tokens = $client->getRequestToken($request_url);
		$request_token = $tokens['oauth_token'];
		$request_token_secret = $tokens['oauth_token_secret'];
		$server_login_file_addr = $host_url.$parent_dir."/".$server_dir_name."/".$server_login_file_name;
		//$server_login_url = $tokens['authentification_url'];
		$message =  "Request Token : $request_token<br/>";
		$message .= "Request Token Secret : $request_token_secret<br/>";
		$message .= "<a href='$server_login_file_addr?oauth_token=$request_token'>Click here to Go to Server Login page </a>";

		echo $message;
?>
