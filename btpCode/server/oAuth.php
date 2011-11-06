<?php
		include('DB/initDB.php');
		include('DB/consumerDB.php');
		$consumerDB = new consumerDB();
		$authentification_url = "http://localhost/oAuth/code/server/login.php";
		 function checkRequest($oAuthProvider){
			/* now that everything is setup we run the checks */
			try{
				$oAuthProvider->checkOAuthRequest();
			} catch(OAuthException $E){
				echo OAuthProvider::reportProblem($E);
				$oauth_error = true;
			}
		}
		 function checkToken($provider){
			global $consumerDB;
			global $oAuthProvider;
			$token_id = $consumerDB -> findByToken($oAuthProvider->token);
			$row = mysql_fetch_array($token_id);
			$token_id = $row['id'];
			
			if(!$token_id){ // token not found
				return OAUTH_TOKEN_REJECTED;
			} 

			$verifier = $consumerDB -> getVerifier($token_id);
			$row = mysql_fetch_array($verifier);
			$verifier = $row['verifier']; 
			$token_type = $consumerDB -> getTokenType($token_id);
			$row = mysql_fetch_array($token_type);
			$token_type = $row['token_type'];
			if($token_type == 1)
			{
			if($verifier != $oAuthProvider->verifier){ // bad verifier for request token
				return OAUTH_VERIFIER_INVALID;
			} 
			}
				$token_secret = $consumerDB->getSecret($token_id);
				$row = mysql_fetch_array($token_secret);
				$token_secret = $row['token_secret'];
				$oAuthProvider->token_secret = $token_secret;
				return OAUTH_OK;
		}
		
		/**
		 * This function check both the timestamp & the nonce
		 * The timestamp has to be less than 5 minutes ago (this is not oauth protocol so feel free to change that)
		 * And the nonce has to be unknown for this consumer
		 * Once everything is OK it saves the nonce in the db
		 * It's called by OAuthCheckRequest()
		 * @param $provider
		 */
		function checkNonce($provider){
			return OAUTH_OK;
/*
			if($this->oauth->timestamp < time() - 5*60){
				return OAUTH_BAD_TIMESTAMP;
			} elseif($this->consumer->hasNonce($provider->nonce,$this->oauth->timestamp)) {
				return OAUTH_BAD_NONCE;
			} else {
				$this->consumer->addNonce($this->oauth->nonce);
				return OAUTH_OK;
			}*/
		}
		
		 function checkConsumer($oAuthProvider){
			global $consumerDB;
			global $oAuthProvider;
			$return = OAUTH_CONSUMER_KEY_UNKNOWN;
			
			$result = $consumerDB -> findByKey($oAuthProvider->consumer_key);
			if($result)
			{
			$row = mysql_fetch_array($result);
			$consumer_id =  $row["id"];
			$result = $consumerDB -> getSecretKey($consumer_id);
			$row = mysql_fetch_array($result);
			$consumer_secret =  $row["consumer_secret"];
			$oAuthProvider->consumer_secret = $consumer_secret; 
					$return = OAUTH_OK;
			}
//			$return = OAUTH_OK;
			return $return;
		}
		function generateRequestToken($oAuthProvider){
			global $authentification_url,$consumerDB;
//		$oAuthProvider = new OAuthProvider();
			
			if($oauth_error){
				return false;
			}
			
			$token = sha1(OAuthProvider::generateToken(20,true));
			$token_secret = sha1(OAuthProvider::generateToken(20,true));
			
			$callback = $oAuthProvider->callback;
			$consumer_key = $oAuthProvider->consumer_key;
//			$consumer_key = "key";
			$result  =  $consumerDB -> findByKey($consumer_key);
			$row = mysql_fetch_array($result);
			$consumer_id =  $row["id"];
//			$consumer_id  =  $consumerDB -> findByKey($consumer_key);
			$result = $consumerDB -> createRequestToken($consumer_id, $token, $token_secret, $callback);
			
			//$consumer = Consumer::findByKey($oAuthProvider->consumer_key);
			
//			Token::createRequestToken($consumer, $token, $token_secret, $callback);
			return "&oauth_token=".$token."&oauth_token_secret=".$token_secret."&oauth_callback_confirmed=true&authentification_url=".$authentification_url;
			
		}
		 /* This function is called when you are requesting a request token
		 * Basicly it disabled the tokenHandler check and force the oauth_callback parameter
		 */
		function setRequestTokenQuery($oAuthProvider){
			$oAuthProvider->isRequestTokenEndpoint(true); 
			$oAuthProvider->addRequiredParameter("oauth_callback");
			
		}
		 function generateVerifier(){
			$verifier = sha1(OAuthProvider::generateToken(20,true));
			return $verifier;
		}
		 function generateAccesstoken($oAuthProvider){
			global $consumerDB;
			
			if($oauth_error){
				return false;
			}
			
			$access_token = sha1(OAuthProvider::generateToken(20,true));
			$secret = sha1(OAuthProvider::generateToken(20,true));
			
			$token_id = $consumerDB -> findByToken($oAuthProvider->token);
			$row = mysql_fetch_array($token_id);
			$token_id = $row['id'];
			$consumerDB -> changeToAccessToken($token_id,$access_token,$secret);	
			return "&oauth_token=".$access_token."&oauth_token_secret=".$secret;
		}
		
		function getUserId($oAuthProvider)
		{
		global $consumerDB;
		$user_id = $consumerDB -> getUserIdByToken($oAuthProvider -> token);	     
		if($user_id)
		{	
			$row = mysql_fetch_array($user_id);
			$user_id = $row['user_id'];
			return $user_id;
		}	
		
		
		}
		function getUserInfo($user_id)
		{
			global $consumerDB;
			$user_info = $consumerDB -> getUserInfo($user_id);
			$row = mysql_fetch_array($user_info);
			
			return $row;

		}

