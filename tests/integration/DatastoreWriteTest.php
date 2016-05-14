<?php

namespace Datastore\Tests;

use Datastore\Datastore;

class DatastoreWriteTest extends TestCase
{


    /** @test */
    public function it_should_be_write_and_readable()
    {
        $datastore = Datastore::root('write1');

        $datastore->write('foo', 'bar');

        $this->assertEquals('bar', $datastore->read('foo'));
    }


    /** @test */
    public function it_should_keep_data_integrity_with_driver()
    {
        $datastore = Datastore::root('write2');

        $datastore->write('foo', 'bar');

        $this->assertEquals('bar', $this->driver['write2']['foo']);
    }


    /** @test */
    public function it_should_have_magic_function_calling()
    {
        $datastore = Datastore::root('write3');

        $datastore->foo()->write('bar', 'foobar');

        $this->assertEquals('foobar', $datastore->read('foo.bar'));
    }


    /** @test */
    public function it_should_support_dot_notation()
    {
        $datastore = Datastore::root('write4');

        $datastore->write('foo.bar', 'foobar');

        $this->assertEquals('foobar', $datastore->read('foo.bar'));
    }


    /** @test */
    public function it_should_support_just_one_argument_when_writing()
    {
        $datastore = Datastore::root('write5');

        $datastore->open('foo')->write('bar');

        $this->assertEquals('bar', $datastore->read('foo'));
    }



    /** @test */
    public function it_should_not_pass_by_reference_when_written()
    {
        $datastore = Datastore::root('write6');

        $value = $datastore->write('foo.bar', 'foobar');
        $value = 'something else';

        $this->assertEquals('foobar', $datastore->read('foo.bar'));
    }

}