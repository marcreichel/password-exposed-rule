<?php

namespace MarcReichel\ExposedPassword\Tests\Unit;

use GuzzleHttp\Client;
use MarcReichel\ExposedPassword\NotExposed;
use MarcReichel\ExposedPassword\Tests\TestCase;

class ExposedPasswordTest extends TestCase
{
    /** @var Client $client */
    private $client;

    /** @var NotExposed $notExposed */
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

    public function testMessageIsReturned(): void
    {
        $message = $this->notExposed->message();
        self::assertEquals('The :attribute has been exposed in a data breach.',
            $message);
    }

    public function testValidationFails(): void
    {
        $password = 'password';
        $passed = $this->notExposed->passes('password', $password);
        self::assertFalse($passed);
    }

    public function testValidationPasses(): void
    {
        $password = uniqid('', true);
        $passed = $this->notExposed->passes('password', $password);
        self::assertTrue($passed);
    }
}
