<?php

use PHPUnit\Framework\TestCase;
use Waavi\Sanitizer\Sanitizer;

class StripTagsTest extends TestCase
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
            'name' => '<p>Test paragraph.</p><!-- Comment --> <a href="#fragment">Other text</a>',
        ];
        $rules = [
            'name' => 'strip_tags',
        ];
        $data = $this->sanitize($data, $rules);
        $this->assertEquals('Test paragraph. Other text', $data['name']);
    }
}
