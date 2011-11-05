<?php
	include("oAuth.php");
	//include("../class/Provider.class1.php");
	$oAuthProvider = new OAuthProvider();
	$oAuthProvider->consumerHandler('checkConsumer');
        $oAuthProvider->timestampNonceHandler('checkNonce');  
        $oAuthProvider->tokenHandler('checkToken');  
/*	function __autoload($name){
		require("../class/".$name.".class.php");
	}

	$provider = new Provider();
	       echo 	$provider->checkRequest();
	echo $provider->generateAccessToken();*/
		checkRequest($oAuthProvider);
echo generateAccessToken($oAuthProvider);
?>
