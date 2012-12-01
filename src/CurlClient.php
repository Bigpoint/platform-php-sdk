<?php

namespace Bigpoint;

class CurlClient extends HttpClient
{
    /**
     * @var CurlAdapter
     */
    private $curlAdapter;

    /**
     * @param Response $response
     * @param CurlAdapter $curlAdapter
     */
    public function __construct(
        Response $response,
        CurlAdapter $curlAdapter
    ) {
        parent::__construct($response);

        $this->curlAdapter = $curlAdapter;
    }

    /**
     * (non-PHPdoc)
     * @see HttpClient::send()
     */
    public function send(Request $request)
    {
        $ch = $this->curlAdapter->init($request->getUri());

        $this->curlAdapter->setOption(
            $ch,
            $this->curlAdapter->getConstant('CUSTOMREQUEST'),
            $request->getMethod()
        );

        $headers = array();
        foreach ($request->getHeaders() as $name => $value) {
            $headers[] = $name . ': ' . $value;
        }
        $this->curlAdapter->setOption(
            $ch,
            $this->curlAdapter->getConstant('HTTPHEADER'),
            $headers
        );

        $this->curlAdapter->setOption(
            $ch,
            $this->curlAdapter->getConstant('RETURNTRANSFER'),
            1
        );
        // TODO Auto-generated method stub
    }
}
