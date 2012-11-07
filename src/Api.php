<?php

namespace Bigpoint;

class Api
{
    /**
     * @var string
     */
    const VERSION = 'PROTOTYPE';

    /**
     * @var Oauth2Client
     */
    private $oauth2Client;

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @param Oauth2Client $oauth2Client
     * @param HttpClient $httpClient
     * @param Configuration $configuration
     */
    public function __construct(
        Oauth2Client $oauth2Client,
        HttpClient $httpClient,
        Configuration $configuration
    ) {
        $this->oauth2Client = $oauth2Client;
        $this->httpClient = $httpClient;
        $this->configuration = $configuration;
    }

    public function call($resource, $method = 'GET', $params = array())
    {
        // TODO implement
    }
}
