<?php

class Response
{
    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var string
     */
    private $content;

    /**
     * @var array
     */
    private $headers = array();

    /**
     * Set the status code.
     *
     * @param int $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * Set the content.
     *
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
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
        $this->statusCode = null;
        $this->content = null;
        $this->headers = array();
    }

    /**
     * Get the status code.
     *
     * @return int|null
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Get the content.
     *
     * @return string|null
     */
    public function getContent()
    {
        return $this->content;
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