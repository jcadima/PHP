<?php

/*
* trim whitespaces from string
* lowercase text
* replace whitespaces with dashes (if any)
*/

function generate_slug($string) {
    return str_replace(' ', '-', trim(strtolower($string))  ) ;
}


// Use:
$string = ' Title with spaces ' ;

echo generate_slug($string) ; 

// Output :  title-with-spaces