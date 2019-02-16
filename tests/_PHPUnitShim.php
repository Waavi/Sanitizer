<?php

if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
trait _PHPUnitShim {}
}

if (version_compare(PHP_VERSION, '7.2.0', '<')) {
trait _PHPUnitShim
{

    public function assertIsArray($actual, $message='')
    {
        $this->assertInternalType('array', $actual, $message);
    }

    public function assertIsBool($actual, $message='')
    {
        $this->assertInternalType('bool', $actual, $message);
    }

    public function assertIsFloat($actual, $message='')
    {
        $this->assertInternalType('float', $actual, $message);
    }

    public function assertIsInt($actual, $message='')
    {
        $this->assertInternalType('integer', $actual, $message);
    }

    public function assertIsString($actual, $message='')
    {
        $this->assertInternalType('string', $actual, $message);
    }

}
}
