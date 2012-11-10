<?php

namespace Bigpoint;

abstract class HttpClient
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __construct(
        Request $request,
        Response $response
    ) {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @param string $uri
     * @param string $method
     * @param array $params
     *
     * @return Response
     */
    abstract public function send($uri, $method = 'GET', array $params = array());
}
