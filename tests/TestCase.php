<?php

namespace Datastore\Tests;

/**
 * Class TestCase
 * @package Datastore\Tests
 */
class TestCase extends \PHPUnit_Framework_TestCase
{

    /**
     * @var
     */
    protected $driver;

    /**
     */
    public function setUp()
    {
        parent::setUp();

        $_SESSION = array();

        $this->driver = &$_SESSION;
    }

    /**
     * @param $value
     */
    public function dd($value)
    {
        var_dump($value);
        exit;
    }
}