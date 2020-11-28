<?php

use PHPUnit\Framework\TestCase;
use BinaryCats\Sanitizer\Laravel\Factory;
use BinaryCats\Sanitizer\Sanitizer;

class FactoryTest extends TestCase
{
    public function sanitize($data, $rules)
    {
        $sanitizer = new Sanitizer($data, $rules, [
            'capitalize'  => \BinaryCats\Sanitizer\Filters\Capitalize::class,
            'escape'      => \BinaryCats\Sanitizer\Filters\EscapeHTML::class,
            'format_date' => \BinaryCats\Sanitizer\Filters\FormatDate::class,
            'lowercase'   => \BinaryCats\Sanitizer\Filters\Lowercase::class,
            'uppercase'   => \BinaryCats\Sanitizer\Filters\Uppercase::class,
            'trim'        => \BinaryCats\Sanitizer\Filters\Trim::class,
        ]);
        return $sanitizer->sanitize();
    }

    public function test_custom_closure_filter()
    {
        $factory = new Factory;
        $factory->extend('hash', function ($value) {
            return sha1($value);
        });

        $data = [
            'name' => 'TEST',
        ];
        $rules = [
            'name' => 'hash',
        ];

        $newData = $factory->make($data, $rules)->sanitize();
        $this->assertEquals(sha1('TEST'), $newData['name']);
    }

    public function test_custom_class_filter()
    {
        $factory = new Factory;
        $factory->extend('custom', CustomFilter::class);

        $data = [
            'name' => 'TEST',
        ];
        $rules = [
            'name' => 'custom',
        ];

        $newData = $factory->make($data, $rules)->sanitize();
        $this->assertEquals('TESTTEST', $newData['name']);
    }

    public function test_replace_filter()
    {
        $factory = new Factory;
        $factory->extend('trim', function ($value) {
            return sha1($value);
        });

        $data = [
            'name' => 'TEST',
        ];
        $rules = [
            'name' => 'trim',
        ];

        $newData = $factory->make($data, $rules)->sanitize();
        $this->assertEquals(sha1('TEST'), $newData['name']);
    }
}
