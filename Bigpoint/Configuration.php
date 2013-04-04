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

class Configuration
{
    /**
     * @var string
     */
    const BASE_URI = 'https://api.bigpoint.com/';

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
            return $this->redirectUri;
        }
    }
}
