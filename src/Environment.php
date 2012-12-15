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
     * Get the request URI without the parameters.
     *
     * @return string
     */
    public function getDocumentURI()
    {
        $path = $this->getServerParam('REQUEST_URI');
        $path = parse_url($path, PHP_URL_PATH);
        return (true === empty($path)) ? '' : $path;
    }

    /**
     * Get the current URI.
     *
     * @return string
     */
    public function getCurrentURI()
    {
        // TODO will not work with IIS using ISAPI
        $protocol = $this->getServerParam('HTTPS', null);
        $protocol = (true === empty($protocol)) ? 'http://' : 'https://';

        $host = $this->getServerParam('HTTP_HOST');

        return $protocol . $host . $this->getDocumentURI();
    }
}
