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

class CurlAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CurlAdapter
     */
    private $objectUnderTest;

    /**
     * (non-PHPdoc)
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->objectUnderTest = new CurlAdapter();
    }

    /**
     * Return some cURL option constants.
     */
    public function optionConstantsProvider()
    {
        return array(
            array('PRIVATE', CURLOPT_PRIVATE),
            array('FTPSSLAUTH', CURLOPT_FTPSSLAUTH),
            array('USERAGENT', CURLOPT_USERAGENT),
            array('COOKIE', CURLOPT_COOKIE),
            array('CUSTOMREQUEST', CURLOPT_CUSTOMREQUEST),
            array('RETURNTRANSFER', CURLOPT_RETURNTRANSFER),
            array('CONNECTTIMEOUT', CURLOPT_CONNECTTIMEOUT),
            array('HTTP_VERSION', CURLOPT_HTTP_VERSION),
            array('ENCODING', CURLOPT_ENCODING),
        );
    }

    /**
     * Return some cURL info constants.
     */
    public function infoConstantsProvider()
    {
        return array(
            array('HTTP_CODE', CURLINFO_HTTP_CODE),
            array('HEADER_OUT', CURLINFO_HEADER_OUT),
            array('HEADER_SIZE', CURLINFO_HEADER_SIZE),
            array('NAMELOOKUP_TIME', CURLINFO_NAMELOOKUP_TIME),
            array('PRETRANSFER_TIME', CURLINFO_PRETRANSFER_TIME),
            array('CONTENT_TYPE', CURLINFO_CONTENT_TYPE),
            array('REDIRECT_COUNT', CURLINFO_REDIRECT_COUNT),
        );
    }

    /**
     * @dataProvider optionConstantsProvider
     *
     * @param string $name
     * @param int $value
     */
    public function testGetOptConstant($name, $value)
    {
        $actual = $this->objectUnderTest->getOptConstant($name);

        $this->assertSame($value, $actual);
    }

    /**
     * @dataProvider infoConstantsProvider
     *
     * @param string $name
     * @param int $value
     */
    public function testGetInfoConstant($name, $value)
    {
        $actual = $this->objectUnderTest->getInfoConstant($name);

        $this->assertSame($value, $actual);
    }
}
