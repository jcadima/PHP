<?php

$regexarray = [
	"@^$@i",  // empty, ie: homepage match
	"@^(?P<controller>[a-z-]+)/(?P<action>[a-z-]+)$@i", // matches: controller/action
	"@^(?P<controller>[a-z-]+)/(?P<id>\d+)/(?P<action>[a-z-]+)$@i", // matches:  users/4/delete
	"@^admin/(?P<controller>[a-z-]+)/(?P<action>[a-z-]+)$@i", // matches: admin/users/index
	"@^admin/(?P<controller>[a-z-]+)/(?P<id>\d+)/(?P<action>[a-z-]+)$@i" // matches: admin/users/4/edit
] ;

// test for user with ID 7
foreach( $regexarray as $route ) {
	if( preg_match($route,  "admin/users/7/delete", $matches) ) {
		echo "FOUND MATCH " . PHP_EOL;
	}
}