<?php

namespace Datastore\Tests;

use Datastore\Datastore;

class DatastoreMiscTest extends TestCase
{
//
    /** @test */
    public function it_can_delete_properties()
    {
        $datastore = Datastore::root('misc1');

        $datastore->write('foo.bar', 'foobar');
        $datastore->open('foo')->delete('bar');

        $this->assertCount(0, $datastore->read('foo'));
    }


    /** @test */
    public function it_can_check_if_has_property()
    {
        $datastore = Datastore::root('misc1');

        $datastore->write('foo.bar', 'foobar');

        $this->assertTrue($datastore->open('foo')->has('bar'));
        $this->assertFalse($datastore->open('foo')->has('foo'));
    }

}