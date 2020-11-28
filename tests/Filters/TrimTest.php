<?php

use BinaryCats\Sanitizer\Sanitizer;
use PHPUnit\Framework\TestCase;

class TrimTest extends TestCase
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
    public function it_trims_strings()
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
