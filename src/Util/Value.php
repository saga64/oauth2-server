<?php

namespace League\OAuth2\Server\Util;

class Value
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var null|string
     */
    private $default;

    /**
     * @var \Exception
     */
    private $exception;

    /**
     * @param string     $key Value key
     * @param string     $default
     * @param \Exception $exception
     */
    public function __construct($key, $default = null, \Exception $exception = null)
    {
        $this->key = $key;
        $this->default = $default;
        $this->exception = $exception;
    }

    /**
     * @param $value
     *
     * @return mixed
     * @throws \Exception
     */
    public function evaluate($value)
    {
        if ($value === null) {
            $value = $this->default;
        }

        if ($value === null && $this->exception instanceof \Exception) {
            throw $this->exception;
        }

        return $value;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }
}
