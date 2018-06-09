<?php

namespace richardevcom\PHPHelpers;

/**
 * Convert to timestamp
 *
 * @param string|DateTime $time
 * @param bool            $currentIsDefault
 * @return int
 */
function timestamp($time = null, $currentIsDefault = true): int {
    if ($time instanceof \DateTime) {
        return $time->format('U');
    }
    if (null !== $time) {
        $time = is_numeric($time) ? (int)$time : strtotime($time);
    }
    if (!$time) {
        $time = $currentIsDefault ? time() : 0;
    }
    return $time;
}