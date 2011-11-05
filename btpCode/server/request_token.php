<?php		
	include("oAuth.php");
	$oAuthProvider = new OAuthProvider();

 	$oAuthProvider->consumerHandler('checkConsumer');
        $oAuthProvider->timestampNonceHandler('checkNonce');  
        $oAuthProvider->tokenHandler('checkToken');  
	echo setRequestTokenQuery($oAuthProvider);
		checkRequest($oAuthProvider);
//		$provider -> checkRequest();
	echo generateRequestToken($oAuthProvider);
?>
