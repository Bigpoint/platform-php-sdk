<?php

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
    public function setUp()
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
