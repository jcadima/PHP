<?php
function validateCC($cc_num, $type) {
 
	if($type == "American") {
		$denum = "American Express";
	} elseif($type == "Dinners") {
		$denum = "Diner's Club";
	} elseif($type == "Discover") {
		$denum = "Discover";
	} elseif($type == "Master") {
		$denum = "Master Card";
	} elseif($type == "Visa") {
		$denum = "Visa";
	}
 
	if($type == "American") {
		$pattern = "/^([34|37]{2})([0-9]{13})$/";//American Express
	if (preg_match($pattern,$cc_num)) {
		$verified = true;
	} else {
		$verified = false;
	}
 
 
	} elseif($type == "Dinners") {
		$pattern = "/^([30|36|38]{2})([0-9]{12})$/";//Diner's Club
	if (preg_match($pattern,$cc_num)) {
		$verified = true;
	} else {
		$verified = false;
	}
 
 
	} elseif($type == "Discover") {
		$pattern = "/^([6011]{4})([0-9]{12})$/";//Discover Card
	if (preg_match($pattern,$cc_num)) {
		$verified = true;
	} else {
		$verified = false;
	}
 
 
	} elseif($type == "Master") {
		$pattern = "/^([51|52|53|54|55]{2})([0-9]{14})$/";//Mastercard
	if (preg_match($pattern,$cc_num)) {
		$verified = true;
	} else {
		$verified = false;
	}
 
 
	} elseif($type == "Visa") {
		$pattern = "/^([4]{1})([0-9]{12,15})$/";//Visa
	if (preg_match($pattern,$cc_num)) {
		$verified = true;
	} else {
		$verified = false;
	}
 
	}
 
	if($verified == false) {
		//Do something here in case the validation fails
		echo "Credit card invalid. Please make sure that you entered a valid <em>" . $denum . "</em> credit card ";
 
	} else { // pass
		echo "Your <em>" . $denum . "</em> credit card is valid";
	}
 
 
}

// use a html dropdown for users to select the credit card type

echo validateCC("4111111111111111", "Visa");