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

class FactoryIntegrationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Factory
     */
    private $objectUnderTest;

    /**
     * @var \ReflectionClass
     */
    private $objectUnderTestReflection;

    /**
     * @var array
     */
    private $config;

    protected function setUp()
    {
        $this->config = array(
            'client_id'     => 'CLIENTID',
            'client_secret' => 'CLIENTSECRET',
            'grant_type'    => 'authorization_code',
        );
        $this->objectUnderTest = new Factory();
        $this->objectUnderTestReflection = new \ReflectionClass(
            'Bigpoint\Factory'
        );
    }

    /**
     * @runInSeparateProcess
     */
    public function testCreateApi()
    {
        $actual = $this->objectUnderTest->createApi(
            $this->config
        );

        $this->assertInstanceOf('Bigpoint\Api', $actual);
    }

    public function testCreateEnvironment()
    {
        $method = $this->objectUnderTestReflection->getMethod(
            'createEnvironment'
        );
        $method->setAccessible(true);
        $actualFirst = $method->invoke($this->objectUnderTest);
        $actualSecond = $method->invoke($this->objectUnderTest);

        $this->assertInstanceOf('Bigpoint\Environment', $actualFirst);
        $this->assertSame($actualFirst, $actualSecond);
    }

    public function testCreateSessionAdapter()
    {
        $method = $this->objectUnderTestReflection->getMethod(
            'createSessionAdapter'
        );
        $method->setAccessible(true);
        $actualFirst = $method->invoke($this->objectUnderTest);
        $actualSecond = $method->invoke($this->objectUnderTest);

        $this->assertInstanceOf('Bigpoint\SessionAdapter', $actualFirst);
        $this->assertSame($actualFirst, $actualSecond);
    }

    public function testCreateConfiguration()
    {
        $method = $this->objectUnderTestReflection->getMethod(
            'createConfiguration'
        );
        $method->setAccessible(true);
        $actualFirst = $method->invoke($this->objectUnderTest, $this->config);
        $actualSecond = $method->invoke($this->objectUnderTest, $this->config);

        $this->assertInstanceOf('Bigpoint\Configuration', $actualFirst);
        $this->assertSame($actualFirst, $actualSecond);
    }
}
