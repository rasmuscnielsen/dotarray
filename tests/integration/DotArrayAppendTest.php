<?php

namespace DotArray\Tests;

use DotArray\DotArray;

class DotArrayAppendTest extends TestCase
{


    /** @test */
    public function it_should_merge_values_to_array()
    {
        $memory = null;
        $dotArray = DotArray::init($memory);

        $dotArray->write('foobar', [
            'foo' => 'foo'
        ]);

        $dotArray->append('foobar', [
            'bar' => 'bar'
        ]);

        $this->assertArrayHasKey('foo', $dotArray->read('foobar'));
        $this->assertArrayHasKey('bar', $dotArray->read('foobar'));
    }


    /** @test */
    public function it_should_overwrite_source_if_its_not_array()
    {
        $memory = null;
        $dotArray = DotArray::init($memory);

        $dotArray->write('foo', 'foo');
        $dotArray->append('foo', 'bar');
        $this->assertEquals('bar', $dotArray->read('foo'));

        $dotArray->write('foo', 'foo');
        $dotArray->append('foo', ['foo' => 'bar']);
        $this->assertArrayHasKey('foo', $dotArray->read('foo'));
    }


    /** @test */
    public function it_should_support_dot_paths()
    {
        $memory = null;
        $dotArray = DotArray::init($memory);

        $dotArray->open('foo.bar')->write(['a'=>1, 'b'=>2]);
        $dotArray->append('foo.bar', ['c'=>3]);

        $this->assertEquals(1, $dotArray->read('foo.bar.a'));
        $this->assertEquals(2, $dotArray->read('foo.bar.b'));
        $this->assertEquals(3, $dotArray->read('foo.bar.c'));
    }

}