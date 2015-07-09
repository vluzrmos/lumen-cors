<?php

if (!function_exists('commaSeparated')) {
    /**
     * Parse an array into a comma separated string.
     * @param string|array $value
     * @return string
     */
    function commaSeparated($value)
    {
        return is_array($value) ? implode(', ', $value) : $value;
    }
}
