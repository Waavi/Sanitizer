<?php

use PHPUnit\Framework\TestCase;
use Waavi\Sanitizer\Sanitizer;

class LowercaseTest extends TestCase
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

    /**
     *  @test
     */
    public function it_lowercases_strings()
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
}
