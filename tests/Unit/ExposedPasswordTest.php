<?php

namespace MarcReichel\ExposedPassword\Tests\Unit;

use MarcReichel\ExposedPassword\NotExposed;
use MarcReichel\ExposedPassword\Tests\TestCase;

class ExposedPasswordTest extends TestCase
{
    /** @var \GuzzleHttp\Client $client */
    private $client;

    /** @var \MarcReichel\ExposedPassword\NotExposed $notExposed */
    private $notExposed;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->notExposed = new NotExposed();
    }

    public function tearDown(): void
    {
        $this->client = null;
    }

    public function testMessageIsReturned()
    {
        $message = $this->notExposed->message();
        $this->assertEquals('The :attribute has been exposed in a data breach.',
            $message);
    }

    public function testValidationFails()
    {
        $password = 'password';
        $passed = $this->notExposed->passes('password', $password);
        $this->assertFalse($passed);
    }

    public function testValidationPasses()
    {
        $password = uniqid();
        $passed = $this->notExposed->passes('password', $password);
        $this->assertTrue($passed);
    }
}
