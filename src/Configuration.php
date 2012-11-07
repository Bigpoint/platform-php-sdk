<?php

namespace Bigpoint;

class Configuration
{
    /**
     * @var string
     */
    const BASE_URL = 'https://api-dev.bigpoint.net/';

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $clientSecret;

    /**
     * @param array $config
     */
    public function __construct(
        array $config
    ) {
        $this->clientId = $config['client_id'];
        $this->clientSecret = $config['client_secret'];
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return static::BASE_URL;
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }
}
