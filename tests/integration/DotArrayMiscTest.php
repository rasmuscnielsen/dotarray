<?php

namespace DotArray\Tests;

use DotArray\DotArray;

class DotArrayMiscTest extends TestCase
{
//
    /** @test */
    public function it_can_delete_properties()
    {
        $memory = null;
        $dotArray = DotArray::init($memory);

        $dotArray->write('foo.bar', 'foobar');
        $dotArray->open('foo')->delete('bar');

        $this->assertCount(0, $dotArray->read('foo'));
    }


    /** @test */
    public function it_can_check_if_has_property()
    {
        $memory = null;
        $dotArray = DotArray::init($memory);

        $dotArray->write('foo.bar', 'foobar');

        $this->assertTrue($dotArray->open('foo')->has('bar'));
        $this->assertFalse($dotArray->open('foo')->has('foo'));
    }

}