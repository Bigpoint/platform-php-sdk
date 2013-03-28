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

class EnvironmentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Environment
     */
    private $objectUnderTest;

    /**
     * @var string
     */
    const INVALID_KEY = 'INVALIDKEY';

    /**
     * @var string
     */
    const DEFAULT_VALUE = 'DEFAULTVALUE';

    /**
     * @var string
     */
    const REQUEST_URI = '/site';

    /**
     * @var string
     */
    const REQUEST_URI_WITH_QUERY = '/site?referrer=partner';

    /**
     * @var string
     */
    const HTTP_HOST = 'app.example.com';

    /**
     * @var string
     */
    const REQUEST_URI_EMPTY = '';

    public function superGlobalsProvider()
    {
        return array(
            array(
                array(
                    'foo' => 'bar',
                    'php' => 'hypertext processor',
                ),
                array(
                    'DOCUMENT_ROOT' => '/var/www/default',
                    'SERVER_PROTOCOL' => 'HTTP/1.1',
                ),
            ),
        );
    }

    /**
     * @dataProvider superGlobalsProvider
     *
     * @param array $get
     * @param array $server
     */
    public function testGetGetParam($get, $server)
    {
        $this->objectUnderTest = new Environment($get, $server);
        foreach ($get as $key => $expected) {
            $actual = $this->objectUnderTest->getGetParam($key);
            $this->assertSame($expected, $actual);
        }
    }

    public function testGetGetParamWithInvalidKey()
    {
        $this->objectUnderTest = new Environment(array(), array());
        $actual = $this->objectUnderTest->getGetParam(self::INVALID_KEY);

        $this->assertNull($actual);
    }

    public function testGetGetParamWithInvalidKeyAndDefaultValue()
    {
        $this->objectUnderTest = new Environment(array(), array());
        $actual = $this->objectUnderTest->getGetParam(
            self::INVALID_KEY,
            self::DEFAULT_VALUE
        );

        $this->assertSame(self::DEFAULT_VALUE, $actual);
    }

    /**
     * @dataProvider superGlobalsProvider
     *
     * @param array $get
     * @param array $server
     */
    public function testGetServerParam($get, $server)
    {
        $this->objectUnderTest = new Environment($get, $server);
        foreach ($server as $key => $expected) {
            $actual = $this->objectUnderTest->getServerParam($key);
            $this->assertSame($expected, $actual);
        }
    }

    public function testGetServerParamWithInvalidKey()
    {
        $this->objectUnderTest = new Environment(array(), array());
        $actual = $this->objectUnderTest->getServerParam(self::INVALID_KEY);

        $this->assertNull($actual);
    }

    public function testGetServerParamWithInvalidKeyAndDefaultValue()
    {
        $this->objectUnderTest = new Environment(array(), array());
        $actual = $this->objectUnderTest->getServerParam(
            self::INVALID_KEY,
            self::DEFAULT_VALUE
        );

        $this->assertSame(self::DEFAULT_VALUE, $actual);
    }

    public function testGetDocumentURI()
    {
        $this->objectUnderTest = new Environment(
            array(),
            array(
                'REQUEST_URI' => self::REQUEST_URI_WITH_QUERY,
            )
        );
        $actual = $this->objectUnderTest->getDocumentURI();

        $this->assertSame(self::REQUEST_URI, $actual);
    }

    public function testGetDocumentURIWithEmptyRequestUri()
    {
        $this->objectUnderTest = new Environment(
            array(),
            array(
                'REQUEST_URI' => self::REQUEST_URI_EMPTY,
            )
        );
        $actual = $this->objectUnderTest->getDocumentURI();

        $this->assertSame(self::REQUEST_URI_EMPTY, $actual);
    }

    public function testGetCurrentURIWithHTTP()
    {
        $this->objectUnderTest = new Environment(
            array(),
            array(
                'HTTP_HOST' => self::HTTP_HOST,
                'HTTPS' => null,
            )
        );
        $actual = $this->objectUnderTest->getCurrentURI();
        $expected = 'http://' . self::HTTP_HOST;

        $this->assertSame($expected, $actual);
    }

    public function testGetCurrentURIWithHTTPS()
    {
        $this->objectUnderTest = new Environment(
            array(),
            array(
                'HTTP_HOST' => self::HTTP_HOST,
                'HTTPS' => true,
            )
        );
        $actual = $this->objectUnderTest->getCurrentURI();
        $expected = 'https://' . self::HTTP_HOST;

        $this->assertSame($expected, $actual);
    }
}
