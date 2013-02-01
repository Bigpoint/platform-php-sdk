<?php

namespace Bigpoint;

class Oauth2Client
{
    /**
     * @var string
     */
    const ACCESS_TOKEN_KEY = 'access_token';

    /**
     * @var string
     */
    const TOKEN_ENDPOINT = 'oauth/token';

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
     * @var Request
     */
    private $request;

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @param Environment $environment
     * @param PersistenceInterface $persistence
     * @param HttpClient $httpClient
     * @param Request $request
     * @param Configuration $configuration
     */
    public function __construct(
        Environment $environment,
        PersistenceInterface $persistence,
        HttpClient $httpClient,
        Request $request,
        Configuration $configuration
    ) {
        $this->environment = $environment;
        $this->persistence = $persistence;
        $this->httpClient = $httpClient;
        $this->request = $request;
        $this->configuration = $configuration;
    }

    public function prepareRequest()
    {
        $this->request->setHeader('Accept', 'application/json');
        $this->request->setHeader(
            'Content-type',
            'application/x-www-form-urlencoded'
        );
    }

    /**
     * @param string $code
     * @return Response
     */
    public function requestAccessTokenByAuthorizationCode($code)
    {
        $this->prepareRequest();

        $query = $this->httpClient->buildQuery(
            array(
                'client_id' => $this->configuration->getClientId(),
                'redirect_uri' => $this->configuration->getRedirectURI(),
                'client_secret' => $this->configuration->getClientSecret(),
                'grant_type' => 'authorization_code',
                'code' => $code
            )
        );

        $this->request->setUri(
            $this->configuration->getBaseUri()
            . self::TOKEN_ENDPOINT . '?' . $query
        );

        $this->request->setMethod('GET');

        return $this->httpClient->send($this->request);
    }

    /**
     * @return Response
     */
    public function requestAccessTokenByClientCredentials()
    {
        $this->prepareRequest();

        $this->request->setUri(
            $this->configuration->getBaseUri() . self::TOKEN_ENDPOINT
        );

        $this->request->setMethod('POST');

        $payload = $this->httpClient->buildQuery(
            array(
                'client_id' => $this->configuration->getClientId(),
                'client_secret' => $this->configuration->getClientSecret(),
                'grant_type' => 'client_credentials'
            )
        );

        $this->request->setPayload($payload);

        return $this->httpClient->send($this->request);
    }

    /**
     * Return an access token.
     *
     * @return string|null
     */
    public function getAccessToken()
    {
        $accessToken = $this->persistence->get(self::ACCESS_TOKEN_KEY, null);

        if (null !== $accessToken) {
            return $accessToken;
        }

        if ('authorization_code' === $this->configuration->getGrantType()) {
            $code = $this->environment->getGetParam('code', null);
            if (null === $code) {
                return null;
            }
            $response = $this->requestAccessTokenByAuthorizationCode($code);
        } elseif ('client_credentials' === $this->configuration->getGrantType()) {
            $response = $this->requestAccessTokenByClientCredentials();
        } else {
            return null;
        }

        if ((null === $response) || (200 != $response->getStatusCode())) {
            return null;
        }

        // TODO consider expiration
        // '{"access_token":"[VALUE]","token_type":"bearer","expires_in":43146,"scope":"b a"}'
        $accessToken = json_decode($response->getContent())->access_token;
        $this->persistence->set(self::ACCESS_TOKEN_KEY, $accessToken);

        return $accessToken;
    }
}
