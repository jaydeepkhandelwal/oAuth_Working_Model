<html>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-min.js"/></script>
<script type="text/javascript" src="js/pop.js"/></script>
<script type="text/javascript" src="js/page.js"/></script>
<body>
<div class = 'main-div'>
<h3 class='header'> Client </h3>
 
<?php
		include("settings.php");
		include("popup.php");
	
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
		$board_html = "<div class = 'board'>"; 
		$board_html .= "Client doesn't know you.Now, It will try to get your info.";
		$board_html .= "<div class = 'server-login'> <a href='$server_login_file_addr?oauth_token=$request_token'>Please login on Server </a></div>";
		$board_html .= "<div>";
		echo $board_html;
		
		echo "<div href='#' class='small-text'> What's happening?</div>";
		$message = "Client requested request token and request secret from server.";
		$message .= "<br/>";
		$message .= "In the request, client had to send its consumer key and secret to prove its identity to server ";
		$message .= "<br/>";
		$message .= "Finally,It have request token and request secret";
		$message .= "<br/>";
		$message .= "<div class='tokens'>";
		$message .=  "Request Token ->  $request_token<br/>";
		$message .= "Request Token Secret ->  $request_token_secret<br/>";
		$message .= "</div>";
		$msg_html =  "<div class = 'hidden-text' style='display:none;' > <div id='eventHeader'><span onClick='closeBox();'></span>oAuth Workflow </div>";
		$msg_html.= "<div class ='confirm_message'>$message</div>";
		$msg_html.=  "<div id='eventFooter'>";
	        $msg_html .= '<input type="button" value="Okay" id = "confirm_submit" onClick=""/>';
	        $msg_html .= '<div class="clr"></div>';
        	$msg_html .= "</div>";
        	$msg_html .= "</div>";
		echo $msg_html;


	//	echo $message;
?>
</div>
</body>
