<?php

use Waavi\Sanitizer\Sanitizer;

class SanitizerTest extends PHPUnit_Framework_TestCase
{
    public function sanitize($data, $rules)
    {
        $sanitizer = new Sanitizer($data, $rules, [
            'capitalize'  => \Waavi\Sanitizer\Filters\Capitalize::class,
            'escape'      => \Waavi\Sanitizer\Filters\EscapeHTML::class,
            'format_date' => \Waavi\Sanitizer\Filters\FormatDate::class,
            'lowercase'   => \Waavi\Sanitizer\Filters\Lowercase::class,
            'uppercase'   => \Waavi\Sanitizer\Filters\Uppercase::class,
            'trim'        => \Waavi\Sanitizer\Filters\Trim::class,
        ]);
        return $sanitizer->sanitize();
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

    public function test_escape_string()
    {
        $data = [
            'name' => '<h1>Hello! Unicode chars as Ñ are not escaped.</h1> <script>Neither is content inside HTML tags</script>',
        ];
        $rules = [
            'name' => 'escape',
        ];
        $data = $this->sanitize($data, $rules);
        $this->assertEquals('Hello! Unicode chars as Ñ are not escaped. Neither is content inside HTML tags', $data['name']);
    }

    public function test_date_format()
    {
        $data = [
            'name' => '21/03/1983',
        ];
        $rules = [
            'name' => 'format_date:d/m/Y, Y-m-d',
        ];
        $data = $this->sanitize($data, $rules);
        $this->assertEquals('1983-03-21', $data['name']);
    }

    public function test_date_format_requires_two_args()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        $data = [
            'name' => '21/03/1983',
        ];
        $rules = [
            'name' => 'format_date:d/m/Y',
        ];
        $data = $this->sanitize($data, $rules);
    }

    public function test_lowercase()
    {
        $data = [
            'name' => 'HellO EverYboDy',
        ];
        $rules = [
            'name' => 'lowercase',
        ];
        $data = $this->sanitize($data, $rules);
        $this->assertEquals('hello everybody', $data['name']);
    }

    public function test_uppercase()
    {
        $data = [
            'name' => 'HellO EverYboDy',
        ];
        $rules = [
            'name' => 'uppercase',
        ];
        $data = $this->sanitize($data, $rules);
        $this->assertEquals('HELLO EVERYBODY', $data['name']);
    }

    public function test_capitalize()
    {
        $data = [
            'name' => 'HellO EverYboDy',
        ];
        $rules = [
            'name' => 'capitalize',
        ];
        $data = $this->sanitize($data, $rules);
        $this->assertEquals('Hello Everybody', $data['name']);
    }

    public function test_trim_and_uppercase()
    {
        $data = [
            'name' => '  HellO EverYboDy   ',
        ];
        $rules = [
            'name' => 'trim|capitalize',
        ];
        $data = $this->sanitize($data, $rules);
        $this->assertEquals('Hello Everybody', $data['name']);
    }

    public function test_input_unchanged_if_no_filter()
    {
        $data = [
            'name' => '  HellO EverYboDy   ',
        ];
        $rules = [
            'name' => '',
        ];
        $data = $this->sanitize($data, $rules);
        $this->assertEquals('  HellO EverYboDy   ', $data['name']);
    }

    public function test_exception_if_non_existing_filter()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        $data = [
            'name' => '  HellO EverYboDy   ',
        ];
        $rules = [
            'name' => 'non-filter',
        ];
        $data = $this->sanitize($data, $rules);
    }
}
