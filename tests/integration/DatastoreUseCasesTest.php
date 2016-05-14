<?php

namespace Datastore\Tests;

use Datastore\Datastore;

class DatastoreUseCasesTest extends TestCase
{

    /** @test */
    public function showroom()
    {
        $datastore = Datastore::root('showroom');

        $mercedes = $datastore->open('cars.mercedes');
        $mercedes->write(['model' => 'S', 'origin' => 'germany']);
        $mercedes->append(['passengers' => 4]);
        $mercedes->write('colour', 'blue');

        $this->assertCount(4, $datastore->read('cars.mercedes'));
    }



}