<?php

use Waavi\Sanitizer\Sanitizer;

class SanitizerTest extends PHPUnit_Framework_TestCase
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

    /**
     *  @test
     *  @expectedException \InvalidArgumentException
     */
    public function it_throws_exception_if_non_existing_filter()
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
