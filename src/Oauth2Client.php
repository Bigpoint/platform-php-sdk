<?php

class Oauth2Client
{
    /**
     * @var Environment
     */
    private $environment;

    /**
     * @var PersistenceInterface
     */
    private $persistence;

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @param Environment $environment
     * @param PersistenceInterface $persistence
     * @param HttpClient $httpClient
     */
    public function __construct(
        Environment $environment,
        PersistenceInterface $persistence,
        HttpClient $httpClient
    ) {
        $this->environment = $environment;
        $this->persistence = $persistence;
        $this->httpClient = $httpClient;
    }

    public function getAccessToken()
    {
        // TODO implementation
    }

    public function refreshAccessToken()
    {
        // TODO implementation
    }
}