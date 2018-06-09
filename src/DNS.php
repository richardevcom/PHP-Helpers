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
