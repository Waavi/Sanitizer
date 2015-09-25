<?php

use Waavi\Sanitizer\Sanitizer;

class SanitizerTest extends PHPUnit_Framework_TestCase
{
    public function sanitize($data, $rules)
    {
        $sanitizer = new Sanitizer($data, $rules, [
            'capitalize'  => Filters\Capitalize::class,
            'escape'      => Filters\EscapeHTML::class,
            'format_date' => Filters\FormatDate::class,
            'lowercase'   => Filters\Lowercase::class,
            'uppercase'   => Filters\Uppercase::class,
            'trim'        => Filters\Trim::class,
        ]);
    }

    public function test_trim_string()
    {
        $data = [
            'name' => '  Test  ',
        ];
        $rules = [
            'name' => 'trim',
        ];
        $data = $this->sanitize($data, $rules);
        $this->assertEquals('Test', $data['name']);
    }
}
