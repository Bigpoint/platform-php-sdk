<?php

class Environment
{
    /**
     * @var array
     */
    private $get;

    /**
     * @var array
     */
    private $server;

    /**
     * @param array $get
     * @param array $server
     */
    public function __construct(
        array $get,
        array $server
    ) {
        $this->get = $get;
        $this->server = $server;
    }

    /**
     * Get a GET parameter value.
     *
     * @param string $key
     * @param mixed $default
     */
    public function getGetParam($key, $default = null)
    {
        return isset($this->get[$key]) ? $this->get[$key] : $default;
    }

    /**
     * Get a SERVER parameter value.
     *
     * @param string $key
     * @param mixed $default
     */
    public function getServerParam($key, $default = null)
    {
        return isset($this->server[$key]) ? $this->server[$key] : $default;
    }
}