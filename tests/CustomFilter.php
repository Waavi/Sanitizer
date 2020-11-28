<?php

use PHPUnit\Framework\TestCase;
use BinaryCats\Sanitizer\Contracts\Filter;

class CustomFilter implements Filter
{
    public function apply($value, $options = [])
    {
        return $value . $value;
    }
}
