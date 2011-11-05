<?php
	if(isset($_POST['token'])){
		try {
	 		include("settings.php");
			$oauth_client = new Oauth("key","secret");
			$oauth_client->enableDebug();
			$oauth_client->setToken($_POST['token'],$_POST['token_secret']);
			
   $server_api_file_addr = $host_url.$parent_dir."/".$server_dir_name."/".$server_api_file_name;
			$oauth_client->fetch($server_api_file_addr);
			echo "API RESULT : ".$oauth_client->getLastResponse();
		} catch (OAuthException $E){
			echo $E->debugInfo;
		}
	} else {
		?>
	<form method="post">
		Access token : <input type="text" name="token" value="<?=$_REQUEST['token'];?>" /> <br />
		Access token secret : <input type="text" name="token_secret" value="<?=$_REQUEST['token_secret'];?>" /> <br />
		<input type="submit" value="do An api call" />
	</form>
	<? }  ?>
