
<?php
class consumerDB extends DB
{
public function runQuery($query)
{
		if($this->link)
		{
			$result=mysql_query($query,$this->link);

			if(mysql_affected_rows()>0)
			{
				return $result; 
			}
			return 0;
		}
		return 0;
}
public  function findByKey($key){
			
	$query = "select id from consumer where consumer_key = '".$key."'"; 
			return $this -> runQuery($query);
}
		
public function createRequestToken($consumer_id,$token,$tokensecret,$callback){
			$query = "insert into token (type,consumer_id,token,token_secret,callback_url) values (1,".$consumer_id.",'".$token."','".$tokensecret."','".$callback."')" ;
//			return $query;
			return $this -> runQuery($query);
		}
		public function isActive($id){
			$query = "select active from consumer where id = $id "; 
			return $this->runQuery($query);
		}
		
		public function getKey(){
			$query = "select consumer_key from consumer where id = $id "; 
			return $this->runQuery($query);
		}
		
		public function getSecretKey($id){
			$query = "select consumer_secret from consumer where id = $id "; 
			return $this->runQuery($query);
		}
		public function hasNonce($nonce,$timestamp){
			$query = " select count(*) as cnt from consumer_nonce where timestamp = '".$timestamp."' and nonce = '".$nonce."' and consumer_id = ".$consumer_id;
			$result = $this -> runQuery($query);
			$row = mysql_fetch_array($result);
			if($row['cnt'] == 1)
				return true;
			else
				return false;


		}
		
		public function addNonce($nonce){
			$query = "insert into consumer_nonce (consumer_id,timestamp,nonce) values (".$consumer_id.",".time().",'".$nonce."') ";
			return $this -> runQuery($query);
		}
		public function findByToken($token)
		{
			$query = "select id from token where token = '$token' ";
			
			return $this -> runQuery($query);
		
		}
		public function setVerifier($token_id,$verifier){
			$query = "update token set verifier = '$verifier' where id = $token_id ";
		
			return $this -> runQuery($query);
		}
		public function setUser($token_id , $user_id){
			$query = "update token set user_id = $user_id  where id = $token_id ";
			return $this -> runQuery($query);
			
		}
		public function getCallback($token_id){
			$query = "select callback_url from token where id = $token_id ";
			return $this -> runQuery($query);
		}
		public function ifUserExist($user_name,$password)
		{
			$query = "select id from user where name = '$user_name' and password = '$password' ";
			return $this -> runQuery($query);
		}
		public function getVerifier($token_id){
			$query = "select verifier from token where id = $token_id ";
			return $this -> runQuery($query);
		}
		public function getSecret($token_id)
		{
			$query = "select token_secret from token where id = $token_id ";
			return $this -> runQuery($query);
			
		}
		public function changeToAccessToken($token_id,$token,$secret){
			
		$query = "update token set type = 2 , verifier = '', callback_url = '', token = '".$token."', token_secret = '".$secret."' where id = $token_id  ";	
			return $this -> runQuery($query);
			
		}
		public function getTokenType($token_id)
		{
			$query = "select type from token where id = $token_id ";
			return $this -> runQuery($query);
		}
		public function getUserIdByToken($token)
		{
			$query = "select user_id from token where token = '$token' and type = 2 ";
			return $this -> runQuery($query);
		
		}
		public function getUserInfo($user_id)
		{
			$query = "select name,email from user where id = $user_id ";
			return $this -> runQuery($query);
		}
		/* setters */
		
		
}
?>
