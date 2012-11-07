<?php

namespace Bigpoint;

class Factory
{
    /**
     * @var Environment
     */
    private $environment;

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
            $this->environment = new Environment(
                $_GET,
                $_SERVER
            );
        }
        return $this->environment;
    }

    /**
     * Create a Persistence.
     *
     * @return CookiePersistence
     */
    private function createCookiePersistence()
    {
        return new CookiePersistence(
            $this->createEnvironment()
        );
    }

    /**
     * Create a HttpClient.
     *
     * @return HttpClient
     */
    private function createHttpClient()
    {
        return new CurlClient(
            new Request(),
            new Response()
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
            $this->configuration = new Configuration($config);
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
            $this->createCookiePersistence(),
            $this->createHttpClient(),
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
            $this->createConfiguration($config)
        );
    }
}
