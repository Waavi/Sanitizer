<?php

use PHPUnit\Framework\TestCase;
use Waavi\Sanitizer\Sanitizer;

class EscapeHTMLTest extends TestCase
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
    public function it_escapes_strings()
    {
        $data = [
            'name' => '<h1>Hello! Unicode chars as Ñ are not escaped.</h1> <script>Neither is content inside HTML tags</script>',
        ];
        $rules = [
            'name' => 'escape',
        ];
        $data = $this->sanitize($data, $rules);
        $this->assertEquals('Hello! Unicode chars as Ñ are not escaped. Neither is content inside HTML tags', $data['name']);
    }
}
