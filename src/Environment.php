<?php

namespace Bigpoint;

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
     *
     * @return string
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
     *
     * @return string
     */
    public function getServerParam($key, $default = null)
    {
        return isset($this->server[$key]) ? $this->server[$key] : $default;
    }

    /**
     * Get the current URI.
     *
     * @return string
     */
    public function getCurrentURI()
    {
        $protocol = $this->getServerParam('HTTPS', null);
        $protocol = (null === $protocol) ? 'http://' : 'https://';

        $host = $this->getServerParam('HTTP_HOST');
        $path = $this->getServerParam('REQUEST_URI');

        return $protocol . $host . $path;
    }
}
