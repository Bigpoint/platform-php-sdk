<?php

class Api
{
    /**
     * @var string
     */
    const VERSION = 'PROTOTYPE';

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var string
     */
    private $clienId;

    /**
     * @var string
     */
    private $clienSecret;

    /**
     * @param HttpClient $httpClient
     * @param array $config
     */
    public function __construct(
        HttpClient $httpClient,
        array $config
    ) {
        $this->httpClient = $httpClient;

        $this->clienId = $config['client_id'];
        $this->clienSecret = $config['client_secret'];
    }

    public function call($resource, $method = 'GET', $params = array())
    {
        // TODO implement
    }
}