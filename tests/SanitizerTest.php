<?php

use PHPUnit\Framework\TestCase;
use Waavi\Sanitizer\Sanitizer;

class SanitizerTest extends TestCase
{
    /**
     * @param $data
     * @param $rules
     * @return mixed
     */
    public function sanitize($data, $rules)
    {
        $sanitizer = new Sanitizer($data, $rules);
        return $sanitizer->sanitize();
    }

    public function test_combine_filters()
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

    public function test_array_filters() {
        $data = [
            'name' => '  HellO EverYboDy   ',
        ];
        $rules = [
            'name' => ['trim', 'capitalize'],
        ];
        $data = $this->sanitize($data, $rules);
        $this->assertEquals('Hello Everybody', $data['name']);
    }

    public function test_wildcard_filters()
    {
        $data = [
            'name'    => [
                'first' => ' John ',
                'last'  => ' Doe ',
            ],
            'address' => [
                'street' => ' Some street ',
                'city'   => ' New York ',
            ],
        ];
        $rules = [
            'name.*'       => 'trim',
            'address.city' => 'trim',
        ];
        $data = $this->sanitize($data, $rules);

        $sanitized = [
            'name'    => ['first' => 'John', 'last' => 'Doe'],
            'address' => ['street' => ' Some street ', 'city' => 'New York'],
        ];

        $this->assertEquals($sanitized, $data);
    }

    /**
     *  @test
     */
    public function it_throws_exception_if_non_existing_filter()
    {
        $this->expectException(InvalidArgumentException::class);
        $data = [
            'name' => '  HellO EverYboDy   ',
        ];
        $rules = [
            'name' => 'non-filter',
        ];
        $data = $this->sanitize($data, $rules);
    }

    public function test_it_should_only_sanitize_passed_data()
    {
        $data = [
            'title' => ' Hello WoRlD '
        ];

        $rules = [
            'title' => 'trim',
            'name' => 'trim|escape'
        ];

        $data = $this->sanitize($data, $rules);

        $this->assertArrayNotHasKey('name', $data);
        $this->assertArrayHasKey('title', $data);
        $this->assertEquals(1, count($data));
    }
}
