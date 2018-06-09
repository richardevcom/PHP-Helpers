<?php

namespace richardevcom\PHPHelpers;

/**
 * @param string $email
 * @return string
 */
function get_email_domain($email): string {
    $parts = explode('@', $email);
    $domain = array_pop($parts);
    return @idn_to_utf8($domain, INTL_IDNA_VARIANT_UTS46);
}

/**
 * Check if email domain is in spam list
 * @param string $email
 * @param array $list
 * @return bool
 */
function is_spam_email($email, $list = false){
	global $spam_email_list;
	$spam_email_list = $list;

	if(is_string($spam_email_list)) $spam_email_list = array($spam_email_list);

	if(!isset($spam_email_list) || empty($spam_email_list)){
		if(file_exists('email-spam-list.json')){
			$spam_email_list = json_decode(file_get_contents('email-spam-list.json'), true);
		}else{
			if(!$spam_email_list) throw new \Exception("No spam email domains list provided.");
		}
	}

	if(in_array(get_email_domain($email), $spam_email_list)){
		return true;
	}
	return false;
}