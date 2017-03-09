<?php

namespace DotArray;


class DotArray
{

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


    /**
     * @param $name
     * @return static
     */
    public function __get($name)
    {
        return $this->read($name);
    }

    /* __________________________________________________________________________________ */

    /**
     * @param $memory
     * @return static
     */
    public static function init(&$memory)
    {
        return new static($memory);
    }

    /**
     * Alias for init
     *
     * @param $source
     * @return static
     */
    public static function tap(&$source)
    {
        return new static($source);
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
     * Alias for read
     *
     * @param null $key
     * @param null $default
     * @return mixed
     */
    public function get($key=null, $default=null)
    {
        return $this->read($key, $default);
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
            // Parse dot-path and open a dotArray for the path. Do not auto-create
            $dotArray = $this->open($path, false);

            if(!is_null($dotArray)) // Path existed
            {
                return $dotArray->read($property, $default);
            }
        }

        return $default;
    }


    /**
     * Alias for write
     *
     * @param $key
     * @param null $value
     * @return null
     */
    public function put($key, $value=null)
    {
        return $this->write($key, $value);
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
        if ($value === null) { return $array = $key; }

        // Also the key can be null
        if (is_null($key)) { return $array = $value; }

        // Parse dot-path and open a dotArray for the path
        $dotArray = $this->open($key);

        return $dotArray->write($value);
    }


    /**
     * @param $key
     * @param null $value
     * @return null
     */
    public function add($key, $value=null)
    {
        return $this->append($key, $value);
    }


    /**
     * @param $key
     * @param null $value
     * @return null
     */
    public function append($key, $value=null)
    {
        // Swap args if only one given
        if($value === null)
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
     * @return $this
     */
    public function truncate($key=null)
    {
        $this->open($key)->write(array());

        return $this;
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


    /**
     * @param $dotPath
     * @param bool $createIfNotExists
     * @return $this
     */
    private function navigateTo($dotPath, $createIfNotExists=true)
    {
        $paths = explode('.', $dotPath);

        $dotArray = $this;

        // Navigate through path
        foreach($paths as $path)
        {
            $dotArray = $dotArray->open($path, $createIfNotExists);

            // Null can be return if requested not to create property
            if(is_null($dotArray)) { return null; }
        }

        return $dotArray;
    }

}