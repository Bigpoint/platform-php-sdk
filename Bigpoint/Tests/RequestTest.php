<?php

namespace Bigpoint;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Request
     */
    private $objectUnderTest;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $headerMock;

    /**
     * (non-PHPdoc)
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->headerMock = $this->getMock('Bigpoint\Header');

        $this->objectUnderTest = new Request($this->headerMock);
    }

    public function methodProvider()
    {
        return array(
            array('POST'),
            array('PUT'),
            array('DELETE'),
            array('GET'),
            array('PATCH'),
            array('HEAD'),
        );
    }

    public function uriProvider()
    {
        return array(
            array('http://api.example.com/resource/1337'),
            array('http://api-dev.example.com/resource'),
        );
    }

    public function payloadProvider()
    {
        return array(
            array('foo=bar&php=hypertext processor'),
            array(json_encode(array('foo=bar&php=hypertext processor'))),
            array(null),
            array(''),
        );
    }

    public function headerProvider()
    {
        return array(
            array('Accept', 'text/plain'),
            array('Accept-Charset', 'utf-8'),
            array('Accept-Encoding', 'gzip, deflate'),
            array('Content-Type', 'application/x-www-form-urlencoded'),
            array('Expires', 'Thu, 01 Dec 1994 16:00:00 GMT'),
            array('Location', 'http://www.w3.org/pub/WWW/People.html'),
        );
    }

    /**
     * @dataProvider methodProvider
     *
     * @param string $method
     */
    public function testSetAndGetMethod($method)
    {
        $this->objectUnderTest->setMethod($method);
        $expected = $method;
        $actual = $this->objectUnderTest->getMethod();

        $this->assertSame($expected, $actual);
    }

    /**
     * @dataProvider uriProvider
     *
     * @param string $uri
     */
    public function testSetAndGetUri($uri)
    {
        $this->objectUnderTest->setUri($uri);
        $expected = $uri;
        $actual = $this->objectUnderTest->getUri();

        $this->assertSame($expected, $actual);
    }

    /**
     * @dataProvider payloadProvider
     *
     * @param string $payload
     */
    public function testSetAndGetPayload($payload)
    {
        $this->objectUnderTest->setPayload($payload);
        $expected = $payload;
        $actual = $this->objectUnderTest->getPayload();

        $this->assertSame($expected, $actual);
    }

    /**
     * @dataProvider headerProvider
     *
     * @param string $name
     * @param string $value
     */
    public function testSetHeader($name, $value)
    {
        $this->headerMock
            ->expects($this->atLeastOnce())
            ->method('setField')
            ->with($this->equalTo($name), $this->equalTo($value));

        $this->objectUnderTest->setHeader($name, $value);
    }

    public function testGetHeader()
    {
        $actual = $this->objectUnderTest->getHeader();

        $this->assertSame($this->headerMock, $actual);
    }

    public function testFlush()
    {
        $this->objectUnderTest->setMethod('PUT');
        $this->objectUnderTest->setUri('http://api.example.com/resource/1337');
        $this->objectUnderTest->setPayload(json_encode(array('foo' => 'bar')));
        $this->headerMock
            ->expects($this->atLeastOnce())
            ->method('flush');
        $this->objectUnderTest->flush();
        $actualMethod = $this->objectUnderTest->getMethod();
        $actualUri = $this->objectUnderTest->getUri();
        $actualPayload = $this->objectUnderTest->getPayload();

        $this->assertNull($actualMethod);
        $this->assertNull($actualUri);
        $this->assertNull($actualPayload);
    }
}
