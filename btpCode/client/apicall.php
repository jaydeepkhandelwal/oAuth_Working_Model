
<html>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/form.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-min.js"/></script>
<script type="text/javascript" src="js/pop.js"/></script>
<script type="text/javascript" src="js/page.js"/></script>
<?php
		try {
	 		include("settings.php");
			$oauth_client = new Oauth("key","secret");
			$oauth_client->enableDebug();
			
			$oauth_client->setToken($_REQUEST['token'],$_REQUEST['token_secret']);
			
   $server_api_file_addr = $host_url.$parent_dir."/".$server_dir_name."/".$server_api_file_name;
			$oauth_client->fetch($server_api_file_addr);
			echo "<div class = 'main-div'>";
			echo "<h3 class='header'> Client </h3>";
			$user_name = $oauth_client -> getLastResponse();
			echo "<div style='text-align:center;'> User Name : ".$user_name.
"</div>";
			echo "</div>";
		} catch (OAuthException $E){
			echo $E->debugInfo;
		}
