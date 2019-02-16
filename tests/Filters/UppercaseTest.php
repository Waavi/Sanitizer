<?php

use PHPUnit\Framework\TestCase;
use Waavi\Sanitizer\Sanitizer;

class UppercaseTest extends TestCase
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
    public function it_uppercases_strings()
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
}
