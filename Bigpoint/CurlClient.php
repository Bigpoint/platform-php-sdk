<?php

namespace Bigpoint;

class CurlClient extends HttpClient
{
    /**
     * Bundle of CA Root Certificates.
     *
     * @var string
     */
    const CA_ROOT_CERTIFICATES_BUNDLE = '/ca-bundle.crt';

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
     * @param string $headerField The header data to be written.
     *
     * @return int The number of bytes written.
     */
    public function headerCallback($ch, $headerField)
    {
        $this->response->setHeader($headerField);

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
        foreach ($request->getHeader() as $name => $value) {
            $headers[] = $request->getHeader()->joinField($name, $value);
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

        $this->curlAdapter->setOption(
            $ch,
            $this->curlAdapter->getOptConstant('CAINFO'),
            __DIR__ . self::CA_ROOT_CERTIFICATES_BUNDLE
        );

        // TODO remove as soon as root certificate is available
        $this->curlAdapter->setOption(
            $ch,
            $this->curlAdapter->getOptConstant('SSL_VERIFYPEER'),
            false
        );

        $this->response->flush();
        $content = $this->curlAdapter->exec($ch);
        if (false === $content) {
            throw new \RuntimeException(
                $this->curlAdapter->getError($ch),
                $this->curlAdapter->getErrno($ch)
            );
        }
        $this->response->setContent($content);
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
