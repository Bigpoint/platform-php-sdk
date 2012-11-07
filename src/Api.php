<?php

namespace Bigpoint;

class Api
{
    /**
     * @var string
     */
    const VERSION = 'PROTOTYPE';

    /**
     * @var string
     */
    const BASE_URL = 'https://api-dev.bigpoint.net/';

    /**
     * @var Oauth2Client
     */
    private $oauth2Client;

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
     * @param Oauth2Client $oauth2Client
     * @param HttpClient $httpClient
     * @param array $config
     */
    public function __construct(
        Oauth2Client $oauth2Client,
        HttpClient $httpClient,
        array $config
    ) {
        $this->oauth2Client = $oauth2Client;
        $this->httpClient = $httpClient;

        $this->clienId = $config['client_id'];
        $this->clienSecret = $config['client_secret'];
    }

    public function call($resource, $method = 'GET', $params = array())
    {
        // TODO implement
    }
}
