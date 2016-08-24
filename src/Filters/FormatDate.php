<?php

namespace Waavi\Sanitizer\Filters;

use Carbon\Carbon;
use InvalidArgumentException;
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
        if (!$value) {
            return $value;
        }
        if (sizeof($options) != 2) {
            throw new InvalidArgumentException('The Sanitizer Format Date filter requires both the current date format as well as the target format.');
        }
        $currentFormat = trim($options[0]);
        $targetFormat  = trim($options[1]);
        return Carbon::createFromFormat($currentFormat, $value)->format($targetFormat);
    }
}
