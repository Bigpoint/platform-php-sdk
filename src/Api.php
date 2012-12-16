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

    public function call($resource, $method = 'GET', $params = array())
    {
        $method = strtoupper($method);

        $this->request->setHeader('Accept', 'application/json');
        $this->request->setMethod($method);

        // set content type
        if (('GET' === $method) || ('POST' === $method)) {
            $contentType
                = 'application/x-www-form-urlencoded;version=' . self::VERSION;
        } else {
            $contentType
                = 'application/json;version=' . self::VERSION;
        }
        $this->request->setHeader('Content-type', $contentType);

        // set uri
        $query = array(
            'access_token' => $this->oauth2Client->getAccessToken()
        );
        if ('GET' === $method) {
            $query = array_merge($query, $params);
        }
        $this->request->setUri(
            $this->configuration->getBaseUri()
            . $resource . '?' . $this->httpClient->buildQuery($query)
        );

        // set payload
        if ('POST' === $method) {
            $this->request->setPayload($this->httpClient->buildQuery($params));
        } elseif (('GET' !== $method) && ('POST' !== $method)) {
            $this->request->setPayload(json_encode($params));
        }

        return $this->httpClient->send($this->request);
    }
}
