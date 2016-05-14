<?php

namespace Datastore\Tests;

use Datastore\Datastore;

class DatastoreAppendTest extends TestCase
{


    /** @test */
    public function it_should_merge_values_to_array()
    {
        $datastore = Datastore::root('append1');

        $datastore->write('foobar', [
            'foo' => 'foo'
        ]);

        $datastore->append('foobar', [
            'bar' => 'bar'
        ]);

        $this->assertArrayHasKey('foo', $datastore->read('foobar'));
        $this->assertArrayHasKey('bar', $datastore->read('foobar'));
    }


    /** @test */
    public function it_should_overwrite_source_if_its_not_array()
    {
        $datastore = Datastore::root('append2');

        $datastore->write('foo', 'foo');
        $datastore->append('foo', 'bar');
        $this->assertEquals('bar', $datastore->read('foo'));

        $datastore->write('foo', 'foo');
        $datastore->append('foo', ['foo' => 'bar']);
        $this->assertArrayHasKey('foo', $datastore->read('foo'));
    }


    /** @test */
    public function it_should_support_dot_paths()
    {
        $datastore = Datastore::root('append3');

        $datastore->open('foo.bar')->write(['a'=>1, 'b'=>2]);
        $datastore->append('foo.bar', ['c'=>3]);

        $this->assertEquals(1, $datastore->read('foo.bar.a'));
        $this->assertEquals(2, $datastore->read('foo.bar.b'));
        $this->assertEquals(3, $datastore->read('foo.bar.c'));
    }


//
//
//    /** @test */
//    public function it_should_have_magic_function_calling()
//    {
//        $datastore = Datastore::root('write3');
//
//        $datastore->foo()->write('bar', 'foobar');
//
//        $this->assertEquals('foobar', $datastore->read('foo.bar'));
//    }
//
//
//    /** @test */
//    public function it_should_support_dot_notation()
//    {
//        $datastore = Datastore::root('write4');
//
//        $datastore->write('foo.bar', 'foobar');
//
//        $this->assertEquals('foobar', $datastore->read('foo.bar'));
//    }
//
//
//    /** @test */
//    public function it_should_support_just_one_argument_when_writing()
//    {
//        $datastore = Datastore::root('write5');
//
//        $datastore->open('foo')->write('bar');
//
//        $this->assertEquals('bar', $datastore->read('foo'));
//    }
//
//
//
//    /** @test */
//    public function it_should_not_pass_by_reference_when_written()
//    {
//        $datastore = Datastore::root('write6');
//
//        $value = $datastore->write('foo.bar', 'foobar');
//        $value = 'something else';
//
//        $this->assertEquals('foobar', $datastore->read('foo.bar'));
//    }

}