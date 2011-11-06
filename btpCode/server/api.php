<?php		
	include("oAuth.php");
	//include("../class/Provider.class1.php");
	$oAuthProvider = new OAuthProvider();

 	$oAuthProvider->consumerHandler('checkConsumer');
        $oAuthProvider->timestampNonceHandler('checkNonce');  
        $oAuthProvider->tokenHandler('checkToken');  
	
		checkRequest($oAuthProvider);
		$user_id = getUserId($oAuthProvider);
		$user_info = getUserInfo($user_id);
	        $user_email = $user_info['email'];
	        $user_name = $user_info['name'];
			
		echo "You are $user_name and Your Email id is $user_email ";
//		echo "DS";
	/*$provider = new Provider();

		$provider->checkRequest();
		try {
			echo $provider->getUser()->getId();
		} catch(Exception $E){
			echo $E;
		}*/

?>
