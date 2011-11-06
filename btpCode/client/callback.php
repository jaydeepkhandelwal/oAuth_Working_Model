
<html>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/form.css" rel="stylesheet" type="text/css" />
<link href="css/button.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-min.js"/></script>
<script type="text/javascript" src="js/pop.js"/></script>
<script type="text/javascript" src="js/page.js"/></script>
<?php

  $oauth_token = isset($_POST['oauth_token'])?$_POST['oauth_token']:null;
  $oauth_verifier = isset($_POST['oauth_verifier'])?$_POST['oauth_verifier']:null;
  $oauth_token_secret = isset($_POST['oauth_token_secret'])?$_POST['oauth_token_secret']:null;
 
 if(($oauth_token == null) && ($oauth_verifier_secret == null) && ($oauth_token_secret == null))
 {
  include("popup.php");
  $oauth_token = isset($_GET['oauth_token'])?$_GET['oauth_token']:null;
  $oauth_verifier = isset($_GET['oauth_verifier'])?$_GET['oauth_verifier']:null;
  $form = "<div class = 'main-div'>";
$form .= "<h3 class='header'> Client </h3>";
  $form  .= "<form method='post'>";
  $form .= "<ol>";
  $form .= "<li>";
  $form .= "<label for='oauth_token_secret'> Enter Token Secret </label>";
  $form .= "<input type='text'  placeholder = 'Request Token Secret'  name='oauth_token_secret' class = 'text'/>";
  $form .= "</li>";
  $form .= "<li>";
  $form .= "<label for='oauth_token'> Request Token </label>";
  $form .= "<input type='text' readonly = 'readonly' value='$oauth_token' name='oauth_token' class= 'text'/>";
  $form .= "</li>";
  $form .= "<li>";
  $form .= "<label for='oauth_token'> Token Verifier </label>";
  $form .= "<input type='text' readonly='readonly' value='$oauth_verifier' name = 'oauth_verifier' class ='text'/>";
  $form .= "</li>";
  $form .= "<li>";
  $form .="<input type = 'submit' class = 'button' value='Submit' style = 'margin-top:30px;'/></form>";
  $form .= "</li>";
 $form .= "<div href='#' class='small-text'> What's happening??</div>";
  $form .= "</div>";
  echo $form;
  $message = "This process will be hidden from user.I am showing it just to explain oAuth workflow.";
	$message .= "<br/>";
	$message .= "Now,Verfier Token is a proof of user logged in Server.Now,client needs to make a final request to get Access Token and Access secret";
	$message .= "<br/>";
	$message .= "And this request will be sent when this form will be submitted after getting filled up by correct request Token Secret.";
		$msg_html =  "<div class = 'hidden-text' style='display:none;' > <div id='eventHeader'><span onClick='closeBox();'></span>oAuth Workflow </div>";
		$msg_html.= "<div class ='confirm_message'>$message</div>";
		$msg_html.=  "<div id='eventFooter'>";
	        $msg_html .= '<input type="button" value="Okay" id = "confirm_submit" onClick=""/>';
	        $msg_html .= '<div class="clr"></div>';
        	$msg_html .= "</div>";
        	$msg_html .= "</div>";
		echo $msg_html;
 }
 else
 { 
 include("settings.php");
 include("popup.php");
 $client = new Oauth("key","secret");
   $client->setToken($oauth_token,$oauth_token_secret);
   $server_access_token_file_addr = $host_url.$parent_dir."/".$server_dir_name."/".$server_access_token_file_name;
   $info = $client->getAccessToken($server_access_token_file_addr,null,$_POST['oauth_verifier']);
				echo "<div class = 'main-div'>";
				echo "<h3 class='header'> Client </h3>";
//				echo "<strong>AccessToken</strong> ".$info['oauth_token']."<br />";
//				echo "<strong>AccessToken Secret</strong> ".$info['oauth_token_secret'];
				echo "<a href=\"$client_api_file_name?token=".$info['oauth_token']."&token_secret=".$info['oauth_token_secret']."\">Access User Info </a>";
		echo "<div href='#' class='small-text'> What's happening??</div>";
				echo "</div>";
				$message = "It will also be hidden from User.Now Finally,Client got Access Token and Access Secret.Now with a button click,it can get access user-resources.Try it Yourself. ";
				$message .= "<br/>";
				$message .= "<div class = 'tokens'>";
				$message .= " Access Token : ".$info['oauth_token']; 
				$message .= "<br/>";
				$message .= " Access Token Secret :".$info['oauth_token_secret']; 
				$message .= "</div>";
		$msg_html =  "<div class = 'hidden-text' style='display:none;' > <div id='eventHeader'><span onClick='closeBox();'></span>oAuth Workflow </div>";
		$msg_html.= "<div class ='confirm_message'>$message</div>";
		$msg_html.=  "<div id='eventFooter'>";
	        $msg_html .= '<input type="button" value="Okay" id = "confirm_submit" onClick=""/>';
	        $msg_html .= '<div class="clr"></div>';
        	$msg_html .= "</div>";
        	$msg_html .= "</div>";
		echo $msg_html;
}
?>
