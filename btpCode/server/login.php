
<html>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/form.css" rel="stylesheet" type="text/css" />
<link href="css/button.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-min.js"/></script>
<script type="text/javascript" src="js/pop.js"/></script>
<script type="text/javascript" src="js/page.js"/></script>
<?
	include("oAuth.php");
	$oAuthProvider = new OAuthProvider();


if(isset($_REQUEST['oauth_token'])){

	$result = $consumerDB -> findByToken($_REQUEST['oauth_token']);
	if($result)
	{
	$row = mysql_fetch_array($result);
	$token_id = $row['id'];
	
		if(!isset($_POST['name'])){
		include("popup.php");
		?>
			<div class = 'main-div'>
			<h3 class='header'> Server </h3>
			<form method=post>
				<ol>
				<li>
				<label for= 'name' >Name  </label><input type="text" id = 'name' name="name" class = 'text' /><br />
				</li>
				<li>
				<label for = 'password' >Password </label><input type="password" id = 'password' name="password" class = 'text' /><br />
				</li>
				<li>
				<input type="submit" class='button' style = 'margin-top:50px;' value="I agree on granting permission to Client" />
				</li>
				</ol>
			</form>
		 <div href='#' class='small-text'> What's happening?</div>
			</div>
		<?
		$message = "Server indentifies Client by checking Request token that is sent as Url query String." ;
		$message .= "<br/>";
		$message .= "Now server is asking user to login so that it can grant access to Client.";
		$message .= "<br/>";
		$message .= "If User successfully logs in then server will generate a Token Verifier and will send it to Client callback url.";
		$msg_html =  "<div class = 'hidden-text' style='display:none;' > <div id='eventHeader'><span onClick='closeBox();'></span>Oauth WorkFlow </div>";
		$msg_html.= "<div class ='confirm_message'>$message</div>";
		$msg_html.=  "<div id='eventFooter'>";
	        $msg_html .= '<input type="button" value="Okay" id = "confirm_submit" onClick=""/>';
	        $msg_html .= '<div class="clr"></div>';
        	$msg_html .= "</div>";
        	$msg_html .= "</div>";
		echo $msg_html;
		} else {
			$user_id = $consumerDB -> ifUserExist($_POST['name'],$_POST['password']);			      
			$row = mysql_fetch_array($user_id);
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
				echo "User Name or Password does not exist";
			}
		}
	} else {
		echo "Token does not exist";
	}
} else {
	echo "Please send oAuth Token";
}
