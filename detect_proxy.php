<?php

function detectProxy () {
    $proxy_headers = array(
        'HTTP_VIA',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_FORWARDED',
        'HTTP_CLIENT_IP',
        'HTTP_FORWARDED_FOR_IP',
        'VIA',
        'X_FORWARDED_FOR',
        'FORWARDED_FOR',
        'X_FORWARDED',
        'FORWARDED',
        'CLIENT_IP',
        'FORWARDED_FOR_IP',
        'HTTP_PROXY_CONNECTION'
    );
    foreach($proxy_headers as $x){
        if (isset($_SERVER[$x])) 
        	return true;
    }
    
    return false;
}  


$value_proxy = (int)detectProxy() ;
// Detect if client is using a Proxy 
if ( detectProxy() ) {
	$client_proxy = 'Client is using a proxy';
}
else { 
	$client_proxy = 'Client is not using a proxy' ;
}