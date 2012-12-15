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
     * @var Request
     */
    private $request;

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @param Oauth2Client $oauth2Client
     * @param HttpClient $httpClient
     * @param Request $request
     * @param Configuration $configuration
     */
    public function __construct(
        Oauth2Client $oauth2Client,
        HttpClient $httpClient,
        Request $request,
        Configuration $configuration
    ) {
        $this->oauth2Client = $oauth2Client;
        $this->httpClient = $httpClient;
        $this->request = $request;
        $this->configuration = $configuration;
    }

    public function prepareRequest()
    {
        $this->request->setHeader('Accept', 'application/json');
        $this->request->setHeader(
            'Content-type',
            'application/json;version=' . self::VERSION
        );
    }

    public function call($resource, $method = 'GET', $params = array())
    {
        $this->prepareRequest();

        $this->request->setUri(
            $this->configuration->getBaseUri()
            . $resource . '?' . $this->oauth2Client->getAccessToken()
        );

        $this->request->setMethod($method);

        $this->request->setPayload(json_encode($params));

        return $this->httpClient->send($this->request);
    }
}
