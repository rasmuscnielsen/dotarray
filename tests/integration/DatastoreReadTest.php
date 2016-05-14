<?php

namespace Datastore\Tests;

use Datastore\Datastore;

class DatastoreReadTest extends TestCase
{

    /** @test */
    public function it_should_be_readable()
    {
        $this->driver['read1']['foo'] = 'bar';

        $datastore = Datastore::root('read1');

        $this->assertEquals('bar', $datastore->read('foo'));
    }


    /** @test */
    public function it_should_support_dot_notation_when_reading()
    {
        $this->driver['read2']['foo']['bar'] = 'foobar';

        $datastore = Datastore::root('read2');

        $this->assertEquals('foobar', $datastore->read('foo.bar'));
    }



    /** @test */
    public function it_should_support_reading_null_property()
    {
        $this->driver['read2']['foo'] = 'bar';

        $datastore = Datastore::root('read2');

        $this->assertEquals('bar', $datastore->open('foo')->read(null, 'something else'));
    }


    /** @test */
    public function it_should_not_pass_by_reference_when_reading()
    {
        $datastore = Datastore::root('read3');
        $datastore->write('foo.bar', 'foobar');

        $value = $datastore->read('foo.bar');
        $value = 'something else';

        $this->assertEquals('foobar', $datastore->read('foo.bar'));
    }


    /** @test */
    public function it_should_return_default_if_not_exists()
    {
        $datastore = Datastore::root('read4');

        $this->assertEquals('bar', $datastore->read('foo.baz', 'bar'));
    }


    /** @test */
    public function it_should_not_mutate_source_data()
    {
        $datastore = Datastore::root('read5');

        $datastore->read('foo.bar', 'foobar');

        $this->assertEquals(null, $this->driver['read5']);
    }

}