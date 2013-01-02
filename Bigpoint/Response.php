<?php

namespace Bigpoint;

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
     * @var Header
     */
    private $header;

    /**
     * @param Header $header
     */
    public function __construct(
        Header $header
    ) {
        $this->header = $header;
    }

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
     * Set a header field.
     *
     * @param string $field
     */
    public function setHeader($field)
    {
        $header = $this->header->splitField($field);
        if (false !== $header) {
            $this->header->setField(
                $header['name'],
                $header['value']
            );
        }
    }

    /**
     * Clear the properties.
     */
    public function flush()
    {
        $this->statusCode = null;
        $this->content = null;
        $this->header->flush();
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
     * Get the header.
     *
     * @return Header
     */
    public function getHeader()
    {
        return $this->header;
    }
}
