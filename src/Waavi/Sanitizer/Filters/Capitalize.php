<?php

use Waavi\Sanitizer\Contracts\Filter;

class Capitalize implements Filter
{
    /**
     *  Capitalize the given string.
     *
     *  @param  string  $value
     *  @return string
     */
    public static function apply($value, $options = [])
    {
        return is_string($value) ? ucwords(strtolower($value), FILTER_SANITIZE_STRING) : $value;
    }
}
