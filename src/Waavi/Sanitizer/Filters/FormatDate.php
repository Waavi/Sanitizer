<?php

namespace Waavi\Sanitizer\Filters;

use Carbon\Carbon;
use Waavi\Sanitizer\Contracts\Filter;

class FormatDate implements Filter
{
    /**
     *  Lowercase the given string.
     *
     *  @param  string  $value
     *  @return string
     */
    public function apply($value, $options = [])
    {
        if (sizeof($options) != 2 || !$value) {
            return $value;
        }
        $currentFormat = trim($options[0]);
        $targetFormat  = trim($options[1]);
        return Carbon::createFromFormat($currentFormat, $value)->format($targetFormat);
    }
}
