<?php

namespace Waavi\Sanitizer\Filters;

use Illuminate\Support\Str;
use Waavi\Sanitizer\Contracts\Filter;

class Slug implements Filter
{
    /**
     *  Lowercase the given string.
     *
     *  @param  string  $value
     *  @return string
     */
    public function apply($value, $options = [])
    {
        return is_string($value) ? Str::slug($value) : $value;
    }
}
