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
     * @return Response
     */
    abstract public function send($uri, $method = 'GET', $params = array());
}
