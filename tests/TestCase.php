<?php

namespace DotArray\Tests;


/**
 * Class TestCase
 * @package Datastore\Tests
 */
class TestCase extends \PHPUnit_Framework_TestCase
{

    /**
     * @param $value
     */
    public function dd($value)
    {
        var_dump($value);
        exit;
    }

}