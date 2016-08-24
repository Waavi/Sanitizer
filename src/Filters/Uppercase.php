<?php

namespace Waavi\Sanitizer\Filters;

use Waavi\Sanitizer\Contracts\Filter;

class Uppercase implements Filter
{
    /**
     *  Lowercase the given string.
     *
     *  @param  string  $value
     *  @return string
     */
    public function apply($value, $options = [])
    {
        return is_string($value) ? strtoupper($value) : $value;
    }
}
