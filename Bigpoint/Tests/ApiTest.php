<?php
/**
 * Copyright 2013 Bernd Hoffmann <info@gebeat.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace Bigpoint;

class ApiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Api
     */
    private $objectUnderTest;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $oauth2ClientMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $httpClientMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $requestMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $configurationMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $responseMock;

    /**
     * (non-PHPdoc)
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        // $this->oauth2ClientMock = $this->getMock('Bigpoint\Oauth2Client');

        $this->oauth2ClientMock = $this->getMockBuilder('Bigpoint\Oauth2Client')
            ->disableOriginalConstructor()
            ->getMock();

        $this->httpClientMock = $this->getMockForAbstractClass(
            'Bigpoint\HttpClient',
            array(),
            '',
            false
        );

        $this->requestMock = $this->getMockBuilder('Bigpoint\Request')
            ->disableOriginalConstructor()
            ->getMock();

        $this->configurationMock = $this->getMockBuilder('Bigpoint\Configuration')
            ->disableOriginalConstructor()
            ->getMock();

        $this->objectUnderTest = new Api(
            $this->oauth2ClientMock,
            $this->httpClientMock,
            $this->requestMock,
            $this->configurationMock
        );

        $this->responseMock = $this->getMockBuilder('Bigpoint\Response')
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testGetUser()
    {
        $expected = 42;

        $content = json_encode(array('entity_id' => $expected));
        $this->responseMock
            ->expects($this->any())
            ->method('getStatusCode')
            ->will($this->returnValue('200'));
        $this->responseMock
            ->expects($this->any())
            ->method('getContent')
            ->will($this->returnValue($content));
        $this->httpClientMock
            ->expects($this->any())
            ->method('send')
            ->with($this->equalTo($this->requestMock))
            ->will($this->returnValue($this->responseMock));

        $actual = $this->objectUnderTest->getUser();

        $this->assertSame($expected, $actual);
    }

    /**
     * Return a few of HTTP response codes which differ from 200.
     *
     * @return array
     */
    public function noneOkResponseCodesProvider()
    {
        return array(
            array('204'),
            array('401'),
            array('403'),
            array('500'),
            array('502'),
        );
    }

    /**
     * @dataProvider noneOkResponseCodesProvider
     */
    public function testGetUserWithFaultyResponse($responseCode)
    {
        $expected = null;

        $this->responseMock
            ->expects($this->any())
            ->method('getStatusCode')
            ->will($this->returnValue($responseCode));
        $this->responseMock
            ->expects($this->never())
            ->method('getContent');
        $this->httpClientMock
            ->expects($this->any())
            ->method('send')
            ->with($this->equalTo($this->requestMock))
            ->will($this->returnValue($this->responseMock));

        $actual = $this->objectUnderTest->getUser();

        $this->assertSame($expected, $actual);
    }

    public function testGetAuthorizationRequestUri()
    {
        $expected = 'http://api.example.com/oauth/authorize?client_id=client&response_type=code&redirect_uri=uri';

        $this->oauth2ClientMock
            ->expects($this->atLeastOnce())
            ->method('getAuthorizationRequestUri')
            ->will($this->returnValue($expected));

        $actual = $this->objectUnderTest->getAuthorizationRequestUri();

        $this->assertSame($expected, $actual);
    }
}
