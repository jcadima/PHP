<?php
class Recaptcha {
	
	public function __construct(){
		// retrieve config array values
        $this->config = require('config.php');
    }

	public function verifyResponse($recaptcha){
		
		$userIP = $this->getUserIP();

		// Discard empty  submissions and return
		if (empty($recaptcha)) {
			return array(
				'success'     => false,
				'error-codes' => 'Recaptcha is required',
			);
		}

		// get a JSON response
		$jsonresponse = $this->getJSONResponse(
			array(
				'secret'   => $this->config['secret-key'],
				'remoteip' => $userIP,
				'response' => $recaptcha,
			)
		);

		// decoded JSON reCAPTCHA server response
		$responses = json_decode( $jsonresponse, true);

		// Set array keys for success/failure
		if ( isset($responses['success']) and $responses['success'] == true ) {
			$status = true;
		} else {
			$status = false;
			$error = (isset($responses['error-codes'])) ? $responses['error-codes']
				: 'invalid-input-response';
		}

		// return the status and if error-codes (if any)
		return array(
			'success'     => $status,
			'error-codes' => (isset($error)) ? $error : null,
		);
	}

	private function getJSONResponse($data){
		$url = 'https://www.google.com/recaptcha/api/siteverify?'.http_build_query($data);
		$response = file_get_contents($url);

		return $response;
	}

	private function getUserIP(){
	    if( array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
	        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')>0) {
	            $addr = explode(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
	            return trim($addr[0]);
	        } else {
	            return $_SERVER['HTTP_X_FORWARDED_FOR'];
	        }
	    }
	    else {
	        return $_SERVER['REMOTE_ADDR'];
	    }
	}

}

