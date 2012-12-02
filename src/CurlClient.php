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
     * A callback function specified by CURLOPT_HEADERFUNCTION.
     *
     * @param resource $ch The cURL resource.
     * @param string $headerLine The header data to be written.
     *
     * @return int The number of bytes written.
     */
    public function headerCallback($ch, $headerLine)
    {
        $this->response->setHeader($headerLine);
        return strlen($headerLine);
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
            $this->curlAdapter->getOptConstant('CUSTOMREQUEST'),
            $request->getMethod()
        );

        $headers = array();
        foreach ($request->getHeaders() as $name => $value) {
            $headers[] = $name . ': ' . $value;
        }
        $this->curlAdapter->setOption(
            $ch,
            $this->curlAdapter->getOptConstant('HTTPHEADER'),
            $headers
        );

        $this->curlAdapter->setOption(
            $ch,
            $this->curlAdapter->getOptConstant('POSTFIELDS'),
            $request->getPayload()
        );

        $this->curlAdapter->setOption(
            $ch,
            $this->curlAdapter->getOptConstant('RETURNTRANSFER'),
            1
        );

        $this->curlAdapter->setOption(
            $ch,
            $this->curlAdapter->getOptConstant('HEADERFUNCTION'),
            array($this, 'headerCallback')
        );

        $this->response->flush();
        $this->response->setContent($this->curlAdapter->exec($ch));
        $this->response->setStatusCode(
            $this->curlAdapter->getInfo(
                $ch,
                $this->curlAdapter->getInfoConstant('HTTP_CODE')
            )
        );

        $this->curlAdapter->close($ch);

        return clone($this->response);
    }
}
