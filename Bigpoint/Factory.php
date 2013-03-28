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

class Factory
{
    /**
     * @var Environment
     */
    private $environment;

    /**
     * @var SessionAdapter
     */
    private $sessionAdapter;

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * Create the Environment.
     *
     * @return Environment
     */
    private function createEnvironment()
    {
        if (null === $this->environment) {
            $this->environment = new Environment($_GET, $_SERVER);
        }
        return $this->environment;
    }

    /**
     * Create a Request.
     *
     * @return Request
     */
    private function createRequest()
    {
        return new Request(
            new Header()
        );
    }

    /**
     * Create a Response.
     *
     * @return Response
     */
    private function createResponse()
    {
        return new Response(
            new Header()
        );
    }

    /**
     * Create the SessionAdapter.
     */
    private function createSessionAdapter()
    {
        if (null === $this->sessionAdapter) {
            $this->sessionAdapter = new SessionAdapter();
        }
        return $this->sessionAdapter;
    }

    /**
     * Create a Persistence.
     *
     * @return SessionPersistence
     */
    private function createSessionPersistence()
    {
        return new SessionPersistence(
            $this->createSessionAdapter()
        );
    }

    /**
     * Create a DateTime.
     *
     * @return \DateTime
     */
    private function createDateTime()
    {
        return new \DateTime();
    }

    /**
     * Create a HttpClient.
     *
     * @return HttpClient
     */
    private function createHttpClient()
    {
        return new CurlClient(
            $this->createResponse(),
            new CurlAdapter()
        );
    }

    /**
     * Create a Configuration.
     *
     * @return Configuration
     */
    private function createConfiguration($config)
    {
        if (null === $this->configuration) {
            $this->configuration = new Configuration(
                $this->createEnvironment(),
                $config
            );
        }
        return $this->configuration;
    }

    /**
     * Create an Oauth2Client.
     *
     * @return Oauth2Client
     */
    private function createOauth2Client($config)
    {
        return new Oauth2Client(
            $this->createEnvironment(),
            $this->createSessionPersistence(),
            $this->createDateTime(),
            $this->createHttpClient(),
            $this->createRequest(),
            $this->createConfiguration($config)
        );
    }

    /**
     * Create the Api.
     *
     * @return Api
     */
    public function createApi(array $config)
    {
        return new Api(
            $this->createOauth2Client($config),
            $this->createHttpClient(),
            $this->createRequest(),
            $this->createConfiguration($config)
        );
    }
}
