<?php

namespace Datastore;


class Datastore {
//
//    /**
//     * @var
//     */
//    private static $driver = false;

    /**
     * @var
     */
    private $pointer;


    /**
     * @param $pointer
     */
    public function __construct(&$pointer)
    {
        $this->pointer = &$pointer;
    }

    /**
     * @param $name
     * @param $args
     * @return static
     */
    public function __call($name, $args)
    {
        return $this->open($name);
    }

    /* __________________________________________________________________________________ */

//    /**
//     * @param $pointer
//     */
//    public static function setDriver(&$pointer)
//    {
//        self::$driver = $pointer;
//    }


    /**
     * @param $name
     * @return static
     */
    public static function root($name)
    {
//        $driver = &self::$driver;
//
//        if($driver === false)
//        {
//            $driver = &$_SESSION;
//        }
//
//        $driver[$name] = null;

        return new static( $_SESSION[$name] );
    }

    /* __________________________________________________________________________________ */

    /**
     * @param $path
     * @param bool $createIfNotExists
     * @return $this
     */
    public function open($path, $createIfNotExists=true)
    {
        // NULL is given
        if(is_null($path)) { return $this; }

        // A path is given
        if(strpos($path, '.'))
        {
            return $this->navigateTo($path, $createIfNotExists);
        }

        // A property key is given
        if(!$this->has($path))
        {
            // Do not create
            if(!$createIfNotExists)  { return null; }

            // Create with empty array
            $this->pointer[$path] = array();
        }

        return new static($this->pointer[$path]);
    }


    /**
     * @param $dotPath
     * @param bool $createIfNotExists
     * @return $this
     */
    protected function navigateTo($dotPath, $createIfNotExists=true)
    {
        $paths = explode('.', $dotPath);

        $datastore = $this;

        // Navigate through path
        foreach($paths as $path)
        {
            $datastore = $datastore->open($path, $createIfNotExists);

            // Null can be return if requested not to create property
            if(is_null($datastore)) { return null; }
        }

        return $datastore;
    }


    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function read($key=null, $default=null)
    {
        list($path, $property) = $this->getPathAndProperty($key);

        // Only a property key was given
        if($path === '')
        {
            if(is_null($key))
            {
                return $this->pointer;
            }

            // Return property if exists
            if($this->has($property))
            {
                return $this->pointer[$property];
            }

        }

        // A dot-path was given
        else
        {
            // Parse dot-path and open a datastore for the path. Do not auto-create
            $datastore = $this->open($path, false);

            if(!is_null($datastore)) // Path existed
            {
                return $datastore->read($property, $default);
            }
        }

        return $default;
    }


    /**
     * @param $key
     * @param null $value
     * @return null
     */
    public function write($key, $value=null)
    {
        $array = &$this->pointer;

        // If only $key is passed, it is actually the value
        if (count(func_get_args()) === 1) { return $array = $key; }

        // Also the key can be null
        if (is_null($key)) { return $array = $value; }

        // Parse dot-path and open a datastore for the path
        $datastore = $this->open($key);

        return $datastore->write($value);
    }


    /**
     * @param $key
     * @param null $value
     * @return null
     */
    public function append($key, $value=null)
    {
        // Swap args if only one given
        if(count(func_get_args()) === 1)
        {
            $value = $key; $key = null;
        }

        // A property key is given
        if(!strpos($key, '.'))
        {
            $existingProperty = $this->read($key);

            // If existing property is not array, we have to overwrite
            if(!is_array($existingProperty))
            {
                return $this->write($key, $value);
            }

            // When array, we will merge new value
            return $this->write($key, array_merge($existingProperty, $value));
        }

        // A path is given
        list($path, $property) = $this->getPathAndProperty($key);

        return $this->open($path)->append($property, $value);
    }


    /**
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return is_array($this->pointer) && isset($this->pointer[$key]);
    }


    /**
     * @param $key
     * @return bool
     */
    public function delete($key)
    {
        if($this->has($key))
        {
            unset($this->pointer[$key]);
            return true;
        }

        return false;
    }

    // _________________________________________________________________________________________________________________

    /**
     * @param $dotPath
     * @return array
     */
    private function getPathAndProperty($dotPath)
    {
        $paths = explode('.', $dotPath);
        $property = array_pop($paths);
        $path = implode('.', $paths);

        return array($path, $property);
    }

}