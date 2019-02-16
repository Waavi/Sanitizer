<?php

use PHPUnit\Framework\TestCase;
use Waavi\Sanitizer\Sanitizer;

class DigitTest extends TestCase
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
    public function it_string_to_digits()
    {
        $data = [
            'name' => '+08(096)90-123-45q',
        ];
        $rules = [
            'name' => 'digit',
        ];
        $data = $this->sanitize($data, $rules);
        $this->assertEquals('080969012345', $data['name']);
    }

    /**
     *  @test
     */
    public function it_string_to_digits2()
    {
        $data = [
            'name' => 'Qwe-rty!:)',
        ];
        $rules = [
            'name' => 'digit',
        ];
        $data = $this->sanitize($data, $rules);
        $this->assertEquals('', $data['name']);
    }
}
