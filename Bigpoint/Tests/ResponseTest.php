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

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Response
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

        $this->objectUnderTest = new Response($this->headerMock);
    }

    public function testSetAndGetStatusCode()
    {
        $statusCode = 42;
        $this->objectUnderTest->setStatusCode($statusCode);
        $actual = $this->objectUnderTest->getStatusCode();

        $this->assertSame($statusCode, $actual);
    }

    public function testSetAndGetContent()
    {
        $content = 1337;
        $this->objectUnderTest->setContent($content);
        $actual = $this->objectUnderTest->getContent();

        $this->assertSame($content, $actual);
    }

    public function testSetHeaderWithValidField()
    {
        $field = 'Location: http://google.com';
        $header = array(
            'name' => 'Location',
            'value' => 'http://google.com',
        );
        $this->headerMock
            ->expects($this->atLeastOnce())
            ->method('splitField')
            ->with($this->equalTo($field))
            ->will($this->returnValue($header));
        $this->headerMock
            ->expects($this->atLeastOnce())
            ->method('setField')
            ->with(
                $this->equalTo($header['name']),
                $this->equalTo($header['value'])
            );

        $this->objectUnderTest->setHeader($field);
    }

    public function testSetHeaderWithInvalidField()
    {
        $field = 'nginx/1.2.6';

        $this->headerMock
            ->expects($this->atLeastOnce())
            ->method('splitField')
            ->with($this->equalTo($field))
            ->will($this->returnValue(false));
        $this->headerMock
            ->expects($this->never())
            ->method('setField');

        $this->objectUnderTest->setHeader($field);
    }

    public function testFlush()
    {
        $this->headerMock->expects($this->atLeastOnce())->method('flush');
        $this->objectUnderTest->setStatusCode(42);
        $this->objectUnderTest->setContent(1337);
        $this->objectUnderTest->flush();
        $statusCode = $this->objectUnderTest->getStatusCode();
        $content = $this->objectUnderTest->getContent();

        $this->assertNull($statusCode);
        $this->assertNull($content);
    }

    public function testGetHeader()
    {
        $actual = $this->objectUnderTest->getHeader();

        $this->assertSame($this->headerMock, $actual);
    }
}
