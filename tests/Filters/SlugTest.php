<?php

use PHPUnit\Framework\TestCase;
use Waavi\Sanitizer\Sanitizer;

class SlugTest extends TestCase
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
    public function it_slug_strings()
    {
        $data = [
            'slug' => 'HéllO EverY#bõDy',
        ];
        $rules = [
            'slug' => 'slug',
        ];
        $data = $this->sanitize($data, $rules);
        $this->assertEquals('hello-everybody', $data['slug']);
    }
}
