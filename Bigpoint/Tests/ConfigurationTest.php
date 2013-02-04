<?php

namespace Bigpoint;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Configuration
     */
    private $objectUnderTest;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $environmentMock;

    /**
     * @var string
     */
    const BASE_URI = 'https://staging-api.bigpoint.com';

    /**
     * @var string
     */
    const CLIENT_ID = '1337';

    /**
     * @var string
     */
    const CLIENTSECRET = 'QWERTY';

    /**
     * @var string
     */
    const GRANT_TYPE = 'authorization_code';

    /**
     * @var string
     */
    const REDIRECT_URI = 'http://app.example.com/';

    /**
     * (non-PHPdoc)
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->environmentMock = $this
            ->getMockBuilder('Bigpoint\Environment')
            ->disableOriginalConstructor()
            ->getMock();

        $this->objectUnderTest = new Configuration(
            $this->environmentMock,
            array(
                'client_id' => self::CLIENT_ID,
                'client_secret' => self::CLIENTSECRET,
                'grant_type' => self::GRANT_TYPE,
                'redirect_uri' => self::REDIRECT_URI,
            )
        );
    }

    public function testGetBaseUri()
    {
        $actual = $this->objectUnderTest->getBaseUri();

        $this->assertSame(self::BASE_URI, $actual);
    }

    public function testGetClientId()
    {
        $actual = $this->objectUnderTest->getClientId();

        $this->assertSame(self::CLIENT_ID, $actual);
    }

    public function testGetClientSecret()
    {
        $actual = $this->objectUnderTest->getClientSecret();

        $this->assertSame(self::CLIENTSECRET, $actual);
    }

    public function testGetGrantType()
    {
        $actual = $this->objectUnderTest->getGrantType();

        $this->assertSame(self::GRANT_TYPE, $actual);
    }

    public function testGetConfiguredRedirectUri()
    {
        $actual = $this->objectUnderTest->getRedirectURI();

        $this->assertSame(self::REDIRECT_URI, $actual);
    }

    public function testGetEnvironmentRedirectUri()
    {
        $this->objectUnderTest = new Configuration(
            $this->environmentMock,
            array(
                'client_id' => self::CLIENT_ID,
                'client_secret' => self::CLIENTSECRET,
                'grant_type' => self::GRANT_TYPE,
            )
        );
        $environmentUri = self::REDIRECT_URI . '/site';
        $this->environmentMock
            ->expects($this->atLeastOnce())
            ->method('getCurrentURI')
            ->will($this->returnValue($environmentUri));
        $actual = $this->objectUnderTest->getRedirectURI();

        $this->assertSame($environmentUri, $actual);
    }
}
