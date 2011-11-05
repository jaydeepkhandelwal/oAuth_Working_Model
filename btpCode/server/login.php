<?
	include("oAuth.php");
	//require_once("../class/Provider.class1.php");
	$oAuthProvider = new OAuthProvider();


if(isset($_REQUEST['oauth_token'])){

	$result = $consumerDB -> findByToken($_REQUEST['oauth_token']);
	if($result)
	{
	$row = mysql_fetch_array($result);
	$token_id = $row['id'];
	
		if(!isset($_POST['login'])){
		?>
			<form method=post>
				<label>Login : </label><input type="text" name="login" /><br />
				<input type="submit" value="Authenticate to this website" />
			</form>
		<? 
		} else {
			$user_id = $consumerDB -> ifUserExist($_POST['login']);			      $row = mysql_fetch_array($user_id);
			$user_id = $row['id'];
			if($user_id){
				$oauth_verifier = generateVerifier($oAuthProvider);
				$consumerDB -> setVerifier($token_id,$oauth_verifier);
				 $consumerDB -> setUser($token_id , $user_id);
				$callback =$consumerDB -> getCallback($token_id);
				$row = mysql_fetch_array($callback);
				$callback = $row['callback_url'];
				header("location: ".$callback."?&oauth_token=".$_REQUEST['oauth_token']."&oauth_verifier=".$oauth_verifier);
			} else {
				echo "User not found !";
			}
		}
	} else {
		echo "The specified token does not exist";
	}
} else {
	echo "Please specify a oauth_token";
}
