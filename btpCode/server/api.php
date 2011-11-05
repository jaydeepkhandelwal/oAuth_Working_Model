<?php		
	include("oAuth.php");
	//include("../class/Provider.class1.php");
	$oAuthProvider = new OAuthProvider();

 	$oAuthProvider->consumerHandler('checkConsumer');
        $oAuthProvider->timestampNonceHandler('checkNonce');  
        $oAuthProvider->tokenHandler('checkToken');  
	
		checkRequest($oAuthProvider);
		$user_id = getUserId($oAuthProvider);
		echo $user_id;
//		echo "DS";
	/*$provider = new Provider();

		$provider->checkRequest();
		try {
			echo $provider->getUser()->getId();
		} catch(Exception $E){
			echo $E;
		}*/

?>
