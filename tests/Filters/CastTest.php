<?php

use Waavi\Sanitizer\Sanitizer;

class CastTest extends PHPUnit_Framework_TestCase
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
     *  @expectedException \InvalidArgumentException
     */
    public function it_throws_exception_when_no_cast_type_is_set()
    {
        $this->sanitize(['name' => 'Name'], ['name' => 'cast']);
    }

    /**
     *  @test
     *  @expectedException \InvalidArgumentException
     */
    public function it_throws_exception_when_non_existing_cast_type_is_set()
    {
        $this->sanitize(['name' => 'Name'], ['name' => 'cast:bullshit']);
    }

    /**
     *  @test
     */
    public function it_casts_to_integer()
    {
        $results = $this->sanitize(['var' => '15.6'], ['var' => 'cast:integer']);
        $this->assertInternalType('int', $results['var']);
        $this->assertEquals(15, $results['var']);
    }

    /**
     *  @test
     */
    public function it_casts_to_float()
    {
        $results = $this->sanitize(['var' => '15.6'], ['var' => 'cast:double']);
        $this->assertInternalType('float', $results['var']);
        $this->assertEquals(15.6, $results['var']);
    }

    /**
     *  @test
     */
    public function it_casts_to_string()
    {
        $results = $this->sanitize(['var' => 15], ['var' => 'cast:string']);
        $this->assertInternalType('string', $results['var']);
        $this->assertEquals('15', $results['var']);
    }

    /**
     *  @test
     */
    public function it_casts_to_boolean()
    {
        $results = $this->sanitize(['var' => 15], ['var' => 'cast:boolean']);
        $this->assertInternalType('boolean', $results['var']);
        $this->assertEquals(true, $results['var']);
    }

    /**
     *  @test
     */
    public function it_casts_array_to_object()
    {
        $data = [
            'name' => 'Name',
            'cost' => 15.6,
        ];
        $encodedData = $data;
        $results     = $this->sanitize(['var' => $encodedData], ['var' => 'cast:object']);
        $this->assertInstanceOf('stdClass', $results['var']);
        $this->assertEquals('Name', $results['var']->name);
        $this->assertEquals(15.6, $results['var']->cost);
    }

    /**
     *  @test
     */
    public function it_casts_json_to_object()
    {
        $data = [
            'name' => 'Name',
            'cost' => 15.6,
        ];
        $encodedData = json_encode($data);
        $results     = $this->sanitize(['var' => $encodedData], ['var' => 'cast:object']);
        $this->assertInstanceOf('stdClass', $results['var']);
        $this->assertEquals('Name', $results['var']->name);
        $this->assertEquals(15.6, $results['var']->cost);
    }

    /**
     *  @test
     */
    public function it_casts_json_to_array()
    {
        $data = [
            'name' => 'Name',
            'cost' => 15.6,
        ];
        $encodedData = json_encode($data);
        $results     = $this->sanitize(['var' => $encodedData], ['var' => 'cast:array']);
        $this->assertInternalType('array', $results['var']);
        $this->assertEquals('Name', $results['var']['name']);
        $this->assertEquals(15.6, $results['var']['cost']);
    }

    /**
     *  @test
     */
    public function it_casts_array_to_collection()
    {
        $data = [
            'name' => 'Name',
            'cost' => 15.6,
        ];
        $encodedData = $data;
        $results     = $this->sanitize(['var' => $encodedData], ['var' => 'cast:collection']);
        $this->assertInstanceOf('\Illuminate\Support\Collection', $results['var']);
        $this->assertEquals('Name', $results['var']->first());
    }

    /**
     *  @test
     */
    public function it_casts_json_to_collection()
    {
        $data = [
            'name' => 'Name',
            'cost' => 15.6,
        ];
        $encodedData = json_encode($data);
        $results     = $this->sanitize(['var' => $encodedData], ['var' => 'cast:collection']);
        $this->assertInstanceOf('\Illuminate\Support\Collection', $results['var']);
        $this->assertEquals('Name', $results['var']->first());
    }
}
