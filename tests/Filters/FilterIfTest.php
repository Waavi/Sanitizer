<?php

use PHPUnit\Framework\TestCase;
use Waavi\Sanitizer\Sanitizer;

class FilterIfTest extends TestCase
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
    public function it_apply_filter_if_match()
    {
        $data = [
            'name' => 'HellO EverYboDy',
        ];
        $rules = [
            'name' => 'uppercase|filter_if:name,HellO EverYboDy',
        ];
        $data = $this->sanitize($data, $rules);
        $this->assertEquals('HELLO EVERYBODY', $data['name']);
    }

    /**
     *  @test
     */
    public function it_does_not_apply_filter_if_no_match()
    {
        $data = [
            'name' => 'HellO EverYboDy',
        ];
        $rules = [
            'name' => 'uppercase|filter_if:name,no match',
        ];
        $data = $this->sanitize($data, $rules);
        $this->assertEquals('HellO EverYboDy', $data['name']);
    }
}
