<?php

namespace BinaryCats\Sanitizer\Filters;

use BinaryCats\Sanitizer\Contracts\Filter;
use Illuminate\Support\Collection;

class Cast implements Filter
{
    /**
     *  Capitalize the given string.
     *
     *  @param  string  $value
     *  @return string
     */
    public function apply($value, $options = [])
    {
        $type = isset($options[0]) ? $options[0] : null;
        switch ($type) {
            case 'int':
            case 'integer':
                return (int) $value;
            case 'real':
            case 'float':
            case 'double':
                return (float) $value;
            case 'string':
                return (string) $value;
            case 'bool':
            case 'boolean':
                return (bool) $value;
            case 'object':
                return is_array($value) ? (object) $value : json_decode($value, false);
            case 'array':
                return json_decode($value, true);
            case 'collection':
                $array = is_array($value) ? $value : json_decode($value, true);

                return new Collection($array);
            default:
                throw new \InvalidArgumentException("Wrong Sanitizer casting format: {$type}.");
        }
    }
}
