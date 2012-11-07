<?php

namespace Bigpoint;

class Oauth2Client
{
    /**
     * @var string
     */
    const KEY_PREFIX = 'tbbp_';

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
     * @var Configuration
     */
    private $configuration;

    /**
     * @param Environment $environment
     * @param PersistenceInterface $persistence
     * @param HttpClient $httpClient
     * @param Configuration $configuration
     */
    public function __construct(
        Environment $environment,
        PersistenceInterface $persistence,
        HttpClient $httpClient,
        Configuration $configuration
    ) {
        $this->environment = $environment;
        $this->persistence = $persistence;
        $this->httpClient = $httpClient;
        $this->configuration = $configuration;
    }

    public function getAccessToken()
    {
        // TODO implementation

        // if not in persistence

        // then try to fetch code

        // fetch token from code

        // otherwise return null
    }
}
