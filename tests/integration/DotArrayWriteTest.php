<?php

namespace DotArray\Tests;

use DotArray\DotArray;

class DatastoreWriteTest extends TestCase
{

    /** @test */
    public function it_should_be_write_and_readable()
    {
        $memory = null;

        $dotArray = DotArray::init($memory);
        $dotArray->write('foo', 'bar');

        $this->assertEquals('bar', $dotArray->read('foo'));
    }


    /** @test */
    public function it_should_keep_data_integrity_with_memory()
    {
        $memory = null;
        $dotArray = DotArray::init($memory);

        $dotArray->write('foo', 'bar');

        $this->assertEquals('bar', $memory['foo']);
    }


    /** @test */
    public function it_should_have_magic_function_calling()
    {
        $memory = null;
        $dotArray = DotArray::init($memory);

        $dotArray->foo()->write('bar', 'foobar');

        $this->assertEquals('foobar', $dotArray->read('foo.bar'));
    }


    /** @test */
    public function it_should_support_dot_notation()
    {
        $memory = null;

        $dotArray = DotArray::init($memory);
        $dotArray->write('foo.bar', 'foobar');

        $this->assertEquals('foobar', $dotArray->read('foo.bar'));
    }


    /** @test */
    public function it_should_support_just_one_argument_when_writing()
    {
        $memory = null;

        $dotArray = DotArray::init($memory);

        $dotArray->open('foo')->write('bar');

        $this->assertEquals('bar', $dotArray->read('foo'));
    }



    /** @test */
    public function it_should_not_pass_by_reference_when_written()
    {
        $memory = null;

        $dotArray = DotArray::init($memory);

        $value = $dotArray->write('foo.bar', 'foobar');
        $value = 'something else';

        $this->assertEquals('foobar', $dotArray->read('foo.bar'));
    }

}