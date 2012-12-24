<?php

namespace Bigpoint;

class HeaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Header
     */
    private $objectUnderTest;

    /**
     * Prepare object under test.
     */
    protected function setUp()
    {
        $this->objectUnderTest = new Header();
    }

    /**
     * Return valid header fields.
     */
    public function validHeaderFieldsBundleProvider()
    {
        return array(
            array(
                array(
                    array('Location' => 'http://www.w3.org/pub/WWW/People.html'),
                    array('Content-Type' => 'application/x-www-form-urlencoded'),
                    array('X-XSS-Protection' => '1; mode=block'),
                ),
            ),
        );
    }

    /**
     * Return valid header fields.
     *
     * @return array
     */
    public function validHeaderFieldsProvider()
    {
        return array(
            array('Accept', 'text/plain'),
            array('Accept-Charset', 'utf-8'),
            array('Accept-Encoding', 'gzip, deflate'),
            array('Content-Type', 'application/x-www-form-urlencoded'),
            array('If-Match', '"737060cd8c284d8af7ad3082f209582d"'),
            array('Referer', 'http://en.wikipedia.org/wiki/Main_Page'),
            array('Content-Disposition', 'attachment; filename="fname.ext"'),
            array('Expires', 'Thu, 01 Dec 1994 16:00:00 GMT'),
            array('Location', 'http://www.w3.org/pub/WWW/People.html'),
            array('X-XSS-Protection', '1; mode=block'),
        );
    }

    /**
     * Return invalid header fields.
     *
     * @return array
     */
    public function invalidHeaderFieldsProvider()
    {
        return array(
            array('nginx/1.2.6'),
            array('HTTP/1.1'),
            array('From alex@mailgate.exam.ple Mon Dec 4 17:02:25 2006'),
            array('foobar'),
            array('foo; bar'),
        );
    }

    private function prepareFields($fields)
    {
        foreach ($fields as $name => $value) {
            $this->objectUnderTest->setField($name, $value);
        }
    }

    /**
     * @dataProvider validHeaderFieldsProvider
     *
     * @param string $name
     * @param string $value
     */
    public function testSplitHeaderWithValidFields($name, $value)
    {
        $header = $this->objectUnderTest->splitField(
            sprintf('%s: %s', $name, $value)
        );

        $this->assertNotSame(false, $header);
        $this->assertTrue(true === array_key_exists('name', $header));
        $this->assertTrue(true === array_key_exists('value', $header));
        $this->assertSame($name, $header['name']);
        $this->assertSame($value, $header['value']);
    }

    /**
     * @dataProvider invalidHeaderFieldsProvider
     *
     * @param string $field
     */
    public function testSplitHeaderWithInvalidFields($field)
    {
        $header = $this->objectUnderTest->splitField($field);

        $this->assertFalse($header);
    }

    /**
     * @dataProvider validHeaderFieldsProvider
     *
     * @param string $name
     * @param string $value
     */
    public function testSetField($name, $value)
    {
        $this->objectUnderTest->setField($name, $value);

        $actual = $this->objectUnderTest->getField($name);

        $this->assertNotNull($actual);
        $this->assertSame($value, $actual);
    }

    /**
     * @dataProvider validHeaderFieldsBundleProvider
     *
     * @param array $fields
     */
    public function testGetFields($fields)
    {
        $this->prepareFields($fields);
        $actual = $this->objectUnderTest->getFields();

        $this->assertSame($fields, $actual);
    }

    /**
     * @dataProvider validHeaderFieldsBundleProvider
     *
     * @param array $fields
     */
    public function testFlush($fields)
    {
        $this->prepareFields($fields);
        $this->objectUnderTest->flush();
        $actual = $this->objectUnderTest->getFields();

        $this->assertSame(array(), $actual);
    }

    /**
     * @dataProvider validHeaderFieldsBundleProvider
     *
     * @param array $fields
     */
    public function testCount($fields)
    {
        $this->prepareFields($fields);
        $expected = count($fields);
        $actual = count($this->objectUnderTest);

        $this->assertSame($expected, $actual);
    }

    /**
     * @dataProvider validHeaderFieldsBundleProvider
     *
     * @param array $fields
     */
    public function testCurrent($fields)
    {
        $this->prepareFields($fields);
        $expected = current($fields);
        $actual = $this->objectUnderTest->current();

        $this->assertSame($expected, $actual);
    }

    /**
     * @dataProvider validHeaderFieldsBundleProvider
     *
     * @param array $fields
     */
    public function testKey($fields)
    {
        $this->prepareFields($fields);
        $expected = key($fields);
        $actual = $this->objectUnderTest->key();

        $this->assertSame($expected, $actual);
    }

    /**
     * @dataProvider validHeaderFieldsBundleProvider
     *
     * @param array $fields
     */
    public function testNext($fields)
    {
        $this->prepareFields($fields);
        next($fields);
        $this->objectUnderTest->next();
        $expectedName = key($fields);
        $expectedValue = current($fields);
        $actualName = $this->objectUnderTest->key();
        $actualValue = $this->objectUnderTest->current();

        $this->assertSame($expectedName, $actualName);
        $this->assertSame($expectedValue, $actualValue);
    }

    /**
     * @dataProvider validHeaderFieldsBundleProvider
     *
     * @param array $fields
     */
    public function testRewind($fields)
    {
        $this->prepareFields($fields);
        // Advance/move the internal pointer first
        $this->objectUnderTest->next();

        $expectedName = key($fields);
        $expectedValue = current($fields);

        $this->objectUnderTest->rewind();
        $actualName = $this->objectUnderTest->key();
        $actualValue = $this->objectUnderTest->current();

        $this->assertSame($expectedName, $actualName);
        $this->assertSame($expectedValue, $actualValue);
    }

    /**
     * @dataProvider validHeaderFieldsBundleProvider
     *
     * @param array $fields
     */
    public function testValidWithValidPosition($fields)
    {
        $this->prepareFields($fields);
        $actual = $this->objectUnderTest->valid();

        $this->assertTrue($actual);
    }

    /**
     * @dataProvider validHeaderFieldsBundleProvider
     *
     * @param array $fields
     */
    public function testValidWithInvalidPosition($fields)
    {
        $this->prepareFields($fields);
        $number = count($fields);
        for ($i = 0; $i < $number; ++$i) {
            $this->objectUnderTest->next();
        }
        $actual = $this->objectUnderTest->valid();

        $this->assertFalse($actual);
    }

    public function testValidWithEmptyFields()
    {
        $actual = $this->objectUnderTest->valid();

        $this->assertFalse($actual);
    }
}
