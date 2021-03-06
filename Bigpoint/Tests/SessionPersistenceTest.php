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

class SessionPersistenceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SessionPersistence
     */
    private $objectUnderTest;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $sessionAdapterMock;

    /**
     * @var string
     */
    const SESSION_ID = 'NOTEMPTY';

    /**
     * @var string
     */
    const SESSION_ID_EMPTY = '';

    /**
     * @var string
     */
    const KEY = '1337';

    /**
     * @var string
     */
    const VALUE = '42';

    /**
     * @var string
     */
    const VALUE_DEFAULT = '23';

    /**
     * (non-PHPdoc)
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->sessionAdapterMock = $this->getMock('Bigpoint\SessionAdapter');

        $this->objectUnderTest = $this
            ->getMockBuilder('Bigpoint\SessionPersistence')
            ->disableOriginalConstructor()
            // not change the behavior of the methods
            ->setMethods(array('notExistingMethod'))
            ->getMock();
    }

    private function enableOriginalConstructor()
    {
        $this->objectUnderTest->__construct(
            $this->sessionAdapterMock
        );
    }

    public function testInitSession()
    {
        $this->sessionAdapterMock
            ->expects($this->atLeastOnce())
            ->method('id')
            ->will($this->returnValue(self::SESSION_ID_EMPTY));
        $this->sessionAdapterMock
            ->expects($this->atLeastOnce())
            ->method('start');

        $this->enableOriginalConstructor();
    }

    public function testRevivalSession()
    {
        $this->sessionAdapterMock
            ->expects($this->atLeastOnce())
            ->method('id')
            ->will($this->returnValue(self::SESSION_ID));
        $this->sessionAdapterMock
            ->expects($this->never())
            ->method('start');

        $this->enableOriginalConstructor();
    }

    public function testSet()
    {
        $this->sessionAdapterMock
            ->expects($this->atLeastOnce())
            ->method('set')
            ->with(
                $this->equalTo(self::KEY),
                $this->equalTo(self::VALUE)
            );
        $this->enableOriginalConstructor();

        $this->objectUnderTest->set(self::KEY, self::VALUE);
    }

    public function testGet()
    {
        $this->sessionAdapterMock
            ->expects($this->atLeastOnce())
            ->method('get')
            ->with(
                $this->equalTo(self::KEY),
                $this->equalTo(null)
            );
        $this->enableOriginalConstructor();

        $this->objectUnderTest->get(self::KEY);
    }

    public function testGetWithDefault()
    {
        $this->sessionAdapterMock
            ->expects($this->atLeastOnce())
            ->method('get')
            ->with(
                $this->equalTo(self::KEY),
                $this->equalTo(self::VALUE_DEFAULT)
            );
        $this->enableOriginalConstructor();

        $this->objectUnderTest->get(self::KEY, self::VALUE_DEFAULT);
    }

    public function testDelete()
    {
        $this->sessionAdapterMock
            ->expects($this->atLeastOnce())
            ->method('delete')
            ->with(
                $this->equalTo(self::KEY)
            );
        $this->enableOriginalConstructor();

        $this->objectUnderTest->delete(self::KEY);
    }

    public function testFlush()
    {
        $this->sessionAdapterMock
            ->expects($this->atLeastOnce())
            ->method('flush');
        $this->enableOriginalConstructor();

        $this->objectUnderTest->flush();
    }
}
