<?php

namespace Bigpoint;

class Factory
{
    /**
     * @var Environment
     */
    private $environment;

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
     * Create an Oauth2Client.
     *
     * @var Oauth2Client
     */
    private function createOauth2Client()
    {
        return new Oauth2Client(
            $this->createEnvironment(),
            $this->createCookiePersistence(),
            $this->createHttpClient()
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
            $this->createHttpClient(),
            $config
        );
    }
}
