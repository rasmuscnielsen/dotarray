<?php

namespace DotArray\Tests;

use DotArray\DotArray;

class DotArrayReadTest extends TestCase
{

    /** @test */
    public function it_should_be_readable()
    {
        $memory = array('foo' => 'bar');

        $dotArray = DotArray::init($memory);

        $this->assertEquals('bar', $dotArray->read('foo'));
        $this->assertEquals('bar', $dotArray->get('foo'));
    }


    /** @test */
    public function it_should_support_dot_notation_when_reading()
    {
        $memory = array();
        $memory['foo']['bar'] = 'foobar';

        $dotArray = DotArray::init($memory);

        $this->assertEquals('foobar', $dotArray->read('foo.bar'));
    }



    /** @test */
    public function it_should_support_reading_null_property()
    {
        $memory = array('foo' => 'bar');

        $dotArray = DotArray::init($memory);

        $this->assertEquals('bar', $dotArray->open('foo')->read(null, 'something else'));
    }


    /** @test */
    public function it_should_not_pass_by_reference_when_reading()
    {
        $memory = array();

        $dotArray = DotArray::init($memory);
        $dotArray->write('foo.bar', 'foobar');

        $value = $dotArray->read('foo.bar');
        $value = 'something else';

        $this->assertEquals('foobar', $dotArray->read('foo.bar'));
    }


    /** @test */
    public function it_should_return_default_if_not_exists()
    {
        $memory = null;
        $dotArray = DotArray::init($memory);

        $this->assertEquals('bar', $dotArray->read('foo.baz', 'bar'));
    }


    /** @test */
    public function it_should_not_mutate_source_data()
    {
        $memory = null;
        $dotArray = DotArray::init($memory);

        $dotArray->read('foo.bar', 'foobar');

        $this->assertEquals(null, $memory);
    }

}