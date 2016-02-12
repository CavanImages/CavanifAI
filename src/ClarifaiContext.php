<?php

namespace CavanifAI;

class ClarifaiContext
{

		private $client_id;
		private $client_secret;
		private $access_token;
		private $url;

    /**
     * Create a new CavanifAI Instance
     */
    public function __construct($client_id, $client_secret, $version)
    {
			$this->client_id = $client_id;
			
			$this->client_secret = $client_secret;
			
			$this->access_token = NULL;
			
			$this->url = 'https://api.clarifai.com/'.version.'/';
			
    }
		
		public function authenticate()
    {
			
			$postData = array(
				'grant_type' 		=> 'client_credentials',	
				'client_id' 		=> $this->client_id,	
				'client_secret' => $this->client_secret
			);
			
			$payloadString = implode('&', $postData);
			
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL, $this->url.'token/');
			curl_setopt($ch, CURLOPT_POST, true);			
			curl_setopt($ch,CURLOPT_POSTFIELDS, $payloadString);
			
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($ch, CURLOPT_TIMEOUT, 3);
			
			$json = json_decode(curl_exec($ch));
			
			curl_close($ch);
			
			if(isset($json->access_token)){
				
				$this->access_token = $json->access_token;	
				
			} else {
				
				//throw exception
				
			}			
    
		}
		
		public function getToken(){
			
			if(!$this->access_token){
				
				$this->authenticate();
			
			}
			
			return $this->access_token;
			
		}
		
		
		public function call($method, $postData){
			
			$payloadString = implode('&', $postData);
			
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL, $this->url.$method.'/');
			curl_setopt($ch, CURLOPT_POST, true);	
			curl_setopt($ch,CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$this->getToken()));
			
			curl_setopt($ch,CURLOPT_POSTFIELDS, $payloadString);
			
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($ch, CURLOPT_TIMEOUT, 3);
			
			$json = json_decode(curl_exec($ch));
			
			curl_close($ch);
						
			return $json;
			
		}
		
		

}
