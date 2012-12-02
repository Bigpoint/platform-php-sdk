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
     * Generate URL-encoded query string.
     */
    public function buildQuery($data)
    {
        return http_build_query($data, '', '&');
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
