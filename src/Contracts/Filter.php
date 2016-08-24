<?php

namespace Waavi\Sanitizer\Contracts;

interface Filter
{
    /**
     *  Return the result of applying this filter to the given input.
     *
     *  @param  mixed $value
     *  @return mixed
     */
    public function apply($value, $options = []);
}
