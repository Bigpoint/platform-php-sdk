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
     * Split a header field into field-name and field-value.
     *
     * @param string $headerField
     *
     * @return array|false
     */
    private function splitHeaderField($headerField)
    {
        $pattern = '/(?P<name>[\x21\x22-\x27\x2A\x2B\x2D\x2E\x30-\x39\x41-\x5A\x5D-\x7A\x7C\x7E]+)(?:\x3A{1}\x20?)(?P<value>.*)/';
        if (1 !== preg_match($pattern, $headerField, $matches)) {
            return false;
        }
        return array(
            'name' => $matches['name'],
            'value' => $matches['value'],
        );
    }

    /**
     * A callback function specified by CURLOPT_HEADERFUNCTION.
     *
     * @param resource $ch The cURL resource.
     * @param string $headerField The header data to be written.
     *
     * @return int The number of bytes written.
     */
    public function headerCallback($ch, $headerField)
    {
        $header = $this->splitHeaderField($headerField);
        if (false !== $header) {
            $this->response->setHeader($header['name'], $header['value']);
        }
        return strlen($headerField);
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
