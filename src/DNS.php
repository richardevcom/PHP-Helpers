<?php

namespace richardevcom\PHPHelpers;

/**
 * @param string $email
 * @return string
 */
function get_domain($url): string {
    $host = @parse_url($url, PHP_URL_HOST);
    if (!$host) $host = $url;
    return $host;
}

/**
 * @param string $email
 * @return bool
 */
function is_email($email): bool {
    if (empty($email)) {
        return false;
    }
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    return !(filter_var($email, FILTER_VALIDATE_EMAIL) === false);
}