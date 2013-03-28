<?php

namespace Bigpoint;

class Api
{
    /**
     * @var string
     */
    const VERSION = '1.0';

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

    /**
     * @param string $method
     */
    protected function setContentType($method)
    {
        if (('GET' === $method) || ('HEAD' === $method) || ('DELETE' === $method) || ('POST' === $method)) {
            $contentType = 'application/x-www-form-urlencoded;version=' . self::VERSION;
        } else {
            $contentType = 'application/json;version=' . self::VERSION;
        }
        $this->request->setHeader('Content-type', $contentType);
    }

    /**
     * @param string $resource
     * @param string $method
     * @param array $params
     */
    protected function setUri($resource, $method, array $params)
    {
        $query = array(
            'access_token' => $this->oauth2Client->getAccessToken()
        );
        if (('GET' === $method) || ('HEAD' === $method)) {
            $query = array_merge($query, $params);
        }
        $this->request->setUri(
            $this->configuration->getBaseUri()
            . $resource . '?' . $this->httpClient->buildQuery($query)
        );
    }

    /**
     * @param string $method
     * @param array $params
     */
    protected function setPayload($method, array $params)
    {
        if ('POST' === $method) {
            $this->request->setPayload($this->httpClient->buildQuery($params));
        } elseif (('PUT' === $method) && ('PATCH' === $method)) {
            $this->request->setPayload(json_encode($params));
        }
    }

    /**
     * @param string $resource
     * @param string $method
     * @param array $params
     * @return Response
     */
    public function call($resource, $method = 'GET', array $params = array())
    {
        $method = strtoupper($method);

        $this->request->setHeader('Accept', 'application/hal+json, application/json');
        $this->request->setMethod($method);

        $this->setContentType($method);
        $this->setUri($resource, $method, $params);
        $this->setPayload($method, $params);

        $reponse = $this->httpClient->send($this->request);

        if ('403' == $reponse->getStatusCode()) {
            $this->oauth2Client->flushAccessToken();
        }

        return $reponse;
    }

    /**
     * (non-PHPdoc)
     * @see Oauth2Client::getAuthorizationRequestUri()
     */
    public function getAuthorizationRequestUri()
    {
        return $this->oauth2Client->getAuthorizationRequestUri();
    }
}
