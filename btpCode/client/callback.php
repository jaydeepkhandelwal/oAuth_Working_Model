<?php

  $oauth_token = isset($_POST['oauth_token'])?$_POST['oauth_token']:null;
  $oauth_verifier = isset($_POST['oauth_verifier'])?$_POST['oauth_verifier']:null;
  $oauth_token_secret = isset($_POST['oauth_token_secret'])?$_POST['oauth_token_secret']:null;
 
 if(($oauth_token == null) && ($oauth_verifier_secret == null) && ($oauth_token_secret == null))
 {
  $oauth_token = isset($_GET['oauth_token'])?$_GET['oauth_token']:null;
  $oauth_verifier = isset($_GET['oauth_verifier'])?$_GET['oauth_verifier']:null;
  $form  = "<form method='post'>";
  $form .= "<label for='oauth_token_secret'> Enter Token Secret </label>";
  $form .= "<input type='text'  placeholder = 'Request Token Secret'  name='oauth_token_secret'/>";
  $form .= "<label for='oauth_token'> Request_token </label>";
  $form .= "<input type='text' readonly = 'readonly' value='$oauth_token' name='oauth_token'/>";
  $form .= "<label for='oauth_token'> Token_Verifier </label>";
  $form .= "<input type='text' readonly='readonly' value='$oauth_verifier' name = 'oauth_verifier'/>";
  $form .="<input type = 'submit' value='Submit' /></form>";
  echo $form;
 }
 else
 { 
 include("settings.php");
 $client = new Oauth("key","secret");
   $client->setToken($oauth_token,$oauth_token_secret);
   $server_access_token_file_addr = $host_url.$parent_dir."/".$server_dir_name."/".$server_access_token_file_name;
   $info = $client->getAccessToken($server_access_token_file_addr,null,$_POST['oauth_verifier']);
				echo "<strong>AccessToken</strong> ".$info['oauth_token']."<br />";
				echo "<strong>AccessToken Secret</strong> ".$info['oauth_token_secret'];
				echo "<a href=\"$client_api_file_name?token=".$info['oauth_token']."&token_secret=".$info['oauth_token_secret']."\">get your user id with an api call</a>";
}
?>
