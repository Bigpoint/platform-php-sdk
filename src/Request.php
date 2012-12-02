<?php

namespace Bigpoint;

class Request
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $uri;

    /**
     * @var misc
     */
    private $payload;

    /**
     * @var array
     */
    private $headers = array();

    /**
     * Set the method.
     *
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * Set the uri.
     *
     * @param string $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * Set the payload.
     *
     * @param misc $payload
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
    }

    /**
     * Set a header entry.
     *
     * @param string $name
     * @param string $value
     */
    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

    /**
     * Clear the properties.
     */
    public function flush()
    {
        $this->method = null;
        $this->uri = null;
        $this->payload = null;
        $this->headers = array();
    }

    /**
     * Get the method.
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Get the uri.
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Get the payload.
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * Get the headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
