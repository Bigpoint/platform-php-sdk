<?php

namespace Bigpoint;

abstract class HttpClient
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * @param Response $response
     */
    public function __construct(
        Response $response
    ) {
        $this->response = $response;
    }

    /**
     * Send a request.
     *
     * @param Request $request
     *
     * @return Response
     */
    abstract public function send(Request $request);
}
