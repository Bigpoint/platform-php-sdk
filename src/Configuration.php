<?php

namespace Bigpoint;

class Configuration
{
    /**
     * @var string
     */
    //const BASE_URI = 'https://api-dev.bigpoint.net/';
    const BASE_URI = 'http://10.189.175.89:40888/';

    /**
     * @var Environment
     */
    private $environment;

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $clientSecret;

    /**
     * @var string
     */
    private $grantType;

    /**
     * @var string
     */
    private $redirectUri;

    /**
     * @param Environment $environment
     * @param array $config
     */
    public function __construct(
        Environment $environment,
        array $config
    ) {
        $this->environment = $environment;
        $this->clientId = $config['client_id'];
        $this->clientSecret = $config['client_secret'];
        $this->grantType = $config['grant_type'];

        if (true === isset($config['redirect_uri'])) {
            $this->redirectUri = $config['redirect_uri'];
        }
    }

    /**
     * @return string
     */
    public function getBaseUri()
    {
        return static::BASE_URI;
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

    /**
     * @return string
     */
    public function getGrantType()
    {
        return $this->grantType;
    }

    /**
     * @return string
     */
    public function getRedirectURI()
    {
        if (null === $this->redirectUri) {
            return $this->environment->getCurrentURI();
        } else {
            $this->redirectUri;
        }
    }
}
