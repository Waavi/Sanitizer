<?php

namespace Waavi\Sanitizer\Filters;

use Waavi\Sanitizer\Contracts\Filter;

class Capitalize implements Filter
{
    /**
     *  Capitalize the given string.
     *
     *  @param  string  $value
     *  @return string
     */
    public function apply($value, $options = [])
    {
        return is_string($value) ? ucwords(strtolower($value)) : $value;
    }
}
