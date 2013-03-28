<?php
/**
 * Copyright 2013 Bernd Hoffmann <info@gebeat.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace Bigpoint;

class Oauth2Client
{
    /**
     *  @var string
     */
    const GRAND_TYPE_KEY = 'grant_type';

    /**
     * @var string
     */
    const ACCESS_TOKEN_KEY = 'access_token';

    /**
     * @var string
     */
    const EXPIRE_TIME_KEY = 'expire_time';

    /**
     * @var string
     */
    const TOKEN_ENDPOINT = 'oauth/token';

    /**
     * @var string
     */
    const AUTHORIZATION_ENDPOINT = 'oauth/authorize';

    /**
     * @var Environment
     */
    private $environment;

    /**
     * @var PersistenceInterface
     */
    private $persistence;

    /**
     * @var \DateTime
     */
    private $dateTime;

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
        \DateTime $dateTime,
        HttpClient $httpClient,
        Request $request,
        Configuration $configuration
    ) {
        $this->environment = $environment;
        $this->persistence = $persistence;
        $this->dateTime = $dateTime;
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
    private function getAccessTokenFromPersistence()
    {
        $accessToken = $this->persistence->get(self::ACCESS_TOKEN_KEY, null);

        if (null === $accessToken) {
            return null;
        }

        $expireTime = $this->persistence->get(self::EXPIRE_TIME_KEY, null);
        if ($expireTime < $this->dateTime->getTimestamp()) {
            $this->flushAccessToken();
            return null;
        }

        return $accessToken;
    }

    /**
     * @param Response $response
     * @return string
     */
    private function setAccessTokenToPersistence(Response $response)
    {
        // '{"access_token":"[VALUE]","token_type":"bearer","expires_in":43146,"scope":"b a"}'
        $content = json_decode($response->getContent());

        $expireTime = $this->dateTime->getTimestamp() + $content->expires_in;

        $this->persistence->set(self::ACCESS_TOKEN_KEY, $content->access_token);
        $this->persistence->set(self::EXPIRE_TIME_KEY, $expireTime);
        $this->persistence->set(self::GRAND_TYPE_KEY, $this->configuration->getGrantType());

        return $content->access_token;
    }

    /**
     * Return an access token.
     *
     * @throws \RuntimeException
     * @return string|null
     */
    public function getAccessToken()
    {
        $accessToken = $this->getAccessTokenFromPersistence();
        $grandType = $this->configuration->getGrantType();

        if (null !== $accessToken) {
            if ($grandType !== $this->persistence->get(self::GRAND_TYPE_KEY, null)) {
                throw new \RuntimeException('grand_type switching not supported');
            }
            return $accessToken;
        }

        if ('authorization_code' === $grandType) {
            $code = $this->environment->getGetParam('code', null);
            if (null === $code) {
                return null;
            }
            $response = $this->requestAccessTokenByAuthorizationCode($code);
        } elseif ('client_credentials' === $grandType) {
            $response = $this->requestAccessTokenByClientCredentials();
        } else {
            throw new \RuntimeException('invalid grand_type configured');
        }

        if ((null === $response) || (200 != $response->getStatusCode())) {
            return null;
        }

        return $this->setAccessTokenToPersistence($response);
    }

    public function flushAccessToken()
    {
        $this->persistence->flush();
    }

    /**
     * Return the Uri to request for an authorization.
     *
     * @throws \RuntimeException
     * @return string
     */
    public function getAuthorizationRequestUri()
    {
        if ('authorization_code' !== $this->configuration->getGrantType()) {
            throw new \RuntimeException('grand_type must be equal to authorization_code');
        }

        $query = $this->httpClient->buildQuery(
            array(
                'client_id' => $this->configuration->getClientId(),
                'response_type' => 'code',
                'redirect_uri' => $this->configuration->getRedirectURI()
            )
        );

        return $this->configuration->getBaseUri() . self::AUTHORIZATION_ENDPOINT . '?' . $query;
    }
}
