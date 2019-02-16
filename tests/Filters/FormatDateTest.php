<?php

use PHPUnit\Framework\TestCase;
use Waavi\Sanitizer\Sanitizer;

class FormatDateTest extends TestCase
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
    public function it_formats_dates()
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

    /**
     *  @test
     */
    public function it_requires_two_arguments()
    {
        $this->expectException(\InvalidArgumentException::class);
        $data = [
            'name' => '21/03/1983',
        ];
        $rules = [
            'name' => 'format_date:d/m/Y',
        ];
        $data = $this->sanitize($data, $rules);
    }
}
