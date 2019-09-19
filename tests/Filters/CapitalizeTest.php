<?php

use PHPUnit\Framework\TestCase;
use Waavi\Sanitizer\Sanitizer;

class CapitalizeTest extends TestCase
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
    public function it_capitalizes_strings()
    {
        $result = $this->sanitize(['name' => ' jon snow 145'], ['name' => 'capitalize']);
        $this->assertEquals(' Jon Snow 145', $result['name']);
    }

    /**
     *  @test
     */
    public function it_capitalizes_special_characters()
    {
        $result = $this->sanitize(['name' => 'Τάχιστη αλώπηξ'], ['name' => 'capitalize']);
        $this->assertEquals('Τάχιστη Αλώπηξ', $result['name']);
    }
}
