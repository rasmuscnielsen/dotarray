<?php

namespace DotArray\Tests;

use DotArray\DotArray;

class DotArrayUseCasesTest extends TestCase
{

    /** @test */
    public function showroom()
    {
        $memory = null;
        $dotArray = DotArray::init($memory);

        $mercedes = $dotArray->open('cars.mercedes');
        $mercedes->write(['model' => 'S', 'origin' => 'germany']);
        $mercedes->append(['passengers' => 4]);
        $mercedes->write('colour', 'blue');

        $this->assertCount(4, $dotArray->read('cars.mercedes'));
    }



}