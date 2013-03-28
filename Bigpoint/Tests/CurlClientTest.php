<?php

namespace Bigpoint;

class CurlClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CurlClient
     */
    private $objectUnderTest;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $headerMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $requestMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $responseMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $curlAdapterMock;

    /**
     * @var string
     */
    const CA_ROOT_CERTIFICATES = '/ca-bundle.crt';

    /**
     * Prepare system under test.
     */
    protected function setUp()
    {
        $this->headerMock = $this->getMock('Bigpoint\Header');

        $this->requestMock = $this->getMock(
            'Bigpoint\Request',
            array(),
            array($this->headerMock)
        );

        $this->responseMock = $this
            ->getMockBuilder('Bigpoint\Response')
            ->disableOriginalConstructor()
            ->getMock();

        $this->curlAdapterMock = $this->getMock('Bigpoint\CurlAdapter');

        $this->objectUnderTest = new CurlClient(
            $this->responseMock,
            $this->curlAdapterMock
        );
    }

    /**
     * @return array
     */
    public function headerFieldProvider()
    {
        return array(
            array('Location: http://google.de'),
            array('Server: nginx/1.2.6'),
            array('Server: lighttpd/1.4.32'),
        );
    }

    /**
     * @dataProvider headerFieldProvider
     */
    public function testHeaderCallback($field)
    {
        $chStub = new \stdClass(); // resource
        $this->responseMock
            ->expects($this->atLeastOnce())
            ->method('setHeader')
            ->with($this->equalTo($field));
        $actual = $this->objectUnderTest->headerCallback($chStub, $field);
        $expected = strlen($field);

        $this->assertSame($expected, $actual);
    }

    /**
     * Required for unit test of send method.
     *
     * @return array The used header fields.
     */
    private function prepareHeaderMock()
    {
        $this->headerMock
            ->expects($this->at(0))
            ->method('rewind');

        // First iteration
        $this->headerMock
            ->expects($this->at(1))
            ->method('valid')
            ->will($this->returnValue(true));
        $this->headerMock
            ->expects($this->at(2))
            ->method('current')
            ->will($this->returnValue('application/json'));
        $this->headerMock
            ->expects($this->at(3))
            ->method('key')
            ->will($this->returnValue('Accept'));
        $this->headerMock
            ->expects($this->at(4))
            ->method('joinField')
            ->with(
                $this->equalTo('Accept'),
                $this->equalTo('application/json')
            )
            ->will($this->returnValue('Accept: application/json'));
        $this->headerMock
            ->expects($this->at(5))
            ->method('next');

        // Second iteration
        $this->headerMock
            ->expects($this->at(6))
            ->method('valid')
            ->will($this->returnValue(true));
        $this->headerMock
            ->expects($this->at(7))
            ->method('current')
            ->will($this->returnValue('application/x-www-form-urlencoded'));
        $this->headerMock
            ->expects($this->at(8))
            ->method('key')
            ->will($this->returnValue('Content-Type'));
        $this->headerMock
            ->expects($this->at(9))
            ->method('joinField')
            ->with(
                $this->equalTo('Content-Type'),
                $this->equalTo('application/x-www-form-urlencoded')
            )
            ->will($this->returnValue('Content-Type: application/x-www-form-urlencoded'));
        $this->headerMock
            ->expects($this->at(10))
            ->method('next');

        $this->headerMock
            ->expects($this->at(11))
            ->method('valid')
            ->will($this->returnValue(false));

        return array(
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded',
        );
    }

    /**
     * Required for unit test of send method.
     *
     * @param string $uri
     * @param string $method
     * @param string $payload
     */
    private function prepareRequestMock($uri, $method, $payload)
    {
        $this->requestMock
            ->expects($this->atLeastOnce())
            ->method('getUri')
            ->will($this->returnValue($uri));
        $this->requestMock
            ->expects($this->atLeastOnce())
            ->method('getMethod')
            ->will($this->returnValue($method));
        $this->requestMock
            ->expects($this->atLeastOnce())
            ->method('getPayload')
            ->will($this->returnValue($payload));
        $this->requestMock
            ->expects($this->atLeastOnce())
            ->method('getHeader')
            ->will($this->returnValue($this->headerMock));
    }

    /**
     * Required for unit test of send method.
     *
     * @param string $headers
     * @param mixed $ch
     * @param string $uri
     * @param string $method
     * @param string $payload
     */
    private function prepareCurlAdapterMock($headers, $ch, $uri, $method, $payload)
    {
        $this->curlAdapterMock
            ->expects($this->at(0))
            ->method('init')
            ->with($this->equalTo($uri))
            ->will($this->returnValue($ch));
        $this->curlAdapterMock
            ->expects($this->any())
            ->method('getOptConstant')
            ->will($this->returnArgument(0));
        $this->curlAdapterMock
            ->expects($this->at(2))
            ->method('setOption')
            ->with(
                $this->equalTo($ch),
                $this->equalTo('CUSTOMREQUEST'),
                $this->equalTo($method)
            );
        $this->curlAdapterMock
            ->expects($this->at(4))
            ->method('setOption')
            ->with(
                $this->equalTo($ch),
                $this->equalTo('HTTPHEADER'),
                $this->equalTo($headers)
            );
        $this->curlAdapterMock
            ->expects($this->at(6))
            ->method('setOption')
            ->with(
                $this->equalTo($ch),
                $this->equalTo('POSTFIELDS'),
                $this->equalTo($payload)
            );
        $this->curlAdapterMock
            ->expects($this->at(8))
            ->method('setOption')
            ->with(
                $this->equalTo($ch),
                $this->equalTo('RETURNTRANSFER'),
                $this->equalTo(1)
            );
        $this->curlAdapterMock
            ->expects($this->at(10))
            ->method('setOption')
            ->with(
                $this->equalTo($ch),
                $this->equalTo('HEADERFUNCTION'),
                $this->equalTo(
                    array(
                        $this->objectUnderTest,
                        'headerCallback',
                    )
                )
            );
        $this->curlAdapterMock
            ->expects($this->at(12))
            ->method('setOption')
            ->with(
                $this->equalTo($ch),
                $this->equalTo('CAINFO'),
                $this->stringEndsWith(self::CA_ROOT_CERTIFICATES)
            );
        $this->curlAdapterMock
            ->expects($this->any())
            ->method('getInfoConstant')
            ->will($this->returnArgument(0));
    }

    private function prepareGeneral($ch)
    {
        $payload = 'value=1337';
        $uri = 'http://api.example.com/me';
        $method = 'POST';
        $headers = $this->prepareHeaderMock();
        $this->prepareRequestMock($uri, $method, $payload);
        $this->prepareCurlAdapterMock($headers, $ch, $uri, $method, $payload);

        $this->responseMock
            ->expects($this->at(0))
            ->method('flush');
    }

    public function testSend()
    {
        $chStub = new \stdClass();
        $this->prepareGeneral($chStub);

        $content = 1337;
        $this->curlAdapterMock
            ->expects($this->atLeastOnce())
            ->method('exec')
            ->with($this->equalTo($chStub))
            ->will($this->returnValue($content));
        $this->responseMock
            ->expects($this->atLeastOnce())
            ->method('setContent')
            ->with($this->equalTo($content));

        $statusCode = 42;
        $this->curlAdapterMock
            ->expects($this->atLeastOnce())
            ->method('getInfo')
            ->with(
                $this->equalTo($chStub),
                $this->equalTo('HTTP_CODE')
            )
            ->will($this->returnValue($statusCode));
        $this->responseMock
            ->expects($this->atLeastOnce())
            ->method('setStatusCode')
            ->with($this->equalTo($statusCode));

        $this->curlAdapterMock
            ->expects($this->atLeastOnce())
            ->method('close')
            ->with($this->equalTo($chStub));

        $actual = $this->objectUnderTest->send($this->requestMock);

        $this->assertEquals($this->responseMock, $actual);
        $this->assertNotSame($this->responseMock, $actual);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage CURLE_COULDNT_CONNECT
     * @expectedExceptionCode 7
     */
    public function testSendException()
    {
        $chStub = new \stdClass();
        $this->prepareGeneral($chStub);

        $content = false;
        $this->curlAdapterMock
            ->expects($this->atLeastOnce())
            ->method('exec')
            ->with($this->equalTo($chStub))
            ->will($this->returnValue($content));

        $error = 'CURLE_COULDNT_CONNECT';
        $this->curlAdapterMock
            ->expects($this->atLeastOnce())
            ->method('getError')
            ->with($this->equalTo($chStub))
            ->will($this->returnValue($error));

        $errno = 7;
        $this->curlAdapterMock
            ->expects($this->atLeastOnce())
            ->method('getErrno')
            ->with($this->equalTo($chStub))
            ->will($this->returnValue($errno));

        $this->objectUnderTest->send($this->requestMock);
    }
}
