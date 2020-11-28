<?php

use BinaryCats\Sanitizer\Sanitizer;
use PHPUnit\Framework\TestCase;

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

    /**
     *  @test
     */
    public function it_uppercases_special_characters_strings()
    {
        $data = [
            'name' => 'Τάχιστη αλώπηξ',
        ];
        $rules = [
            'name' => 'uppercase',
        ];
        $data = $this->sanitize($data, $rules);
        $this->assertEquals('ΤΆΧΙΣΤΗ ΑΛΏΠΗΞ', $data['name']);
    }
}
