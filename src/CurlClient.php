<?php

namespace Bigpoint;

class CurlClient extends HttpClient
{
    /**
     * @var CurlAdapter
     */
    private $curlAdapter;

    /**
     * @param Request $request
     * @param Response $response
     * @param CurlAdapter $curlAdapter
     */
    public function __construct(
        Request $request,
        Response $response,
        CurlAdapter $curlAdapter
    ) {
        parent::__construct($request, $response);

        $this->curlAdapter = $curlAdapter;
    }

    /**
     * (non-PHPdoc)
     * @see ClientInterface::send()
     */
    public function send($uri, $method = 'GET', array $params = array())
    {
        // TODO Auto-generated method stub
    }
}
