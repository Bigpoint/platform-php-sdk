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

class HttpClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var HttpClient
     */
    private $objectUnderTest;

    /**
     * (non-PHPdoc)
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->objectUnderTest = $this->getMockForAbstractClass(
            'Bigpoint\HttpClient',
            array(),
            '',
            false
        );
    }

    public function queryDataProvider()
    {
        return array(
            array(
                array(
                    'foo'=>'bar',
                    'baz'=>'boom',
                    'cow'=>'milk',
                    'php'=>'hypertextProcessor',
                ),
            ),
            array(
                array(
                    'foo'=>'b a r',
                    'baz'=>'b o o m',
                    'cow'=>'m\i\l\k',
                    'php'=>'h&y&p&e&r&t&e&x&t processor',
                ),
            ),
        );
    }

    /**
     * @dataProvider queryDataProvider
     *
     * @param array $queryData
     */
    public function testBuildQuery($queryData)
    {
        $expected = http_build_query($queryData, '', '&');
        $actual = $this->objectUnderTest->buildQuery($queryData);

        $this->assertSame($expected, $actual);
    }
}
