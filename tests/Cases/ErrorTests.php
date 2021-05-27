<?php

namespace MangoPay\Tests\Cases;

use MangoPay\Libraries\ResponseException;
use MangoPay\UserNatural;

class ErrorTests extends Base
{
    public function testThatFail()
    {
        $this->expectException(ResponseException::class);

        try {
            $this->_api->Users->create(new UserNatural());
        } catch (\Exception $exception) {
            self::assertStringContainsString('FirstName error:', $exception->getMessage());
            self::assertStringContainsString('LastName error:', $exception->getMessage());
            self::assertStringContainsString('Birthday error:', $exception->getMessage());
            self::assertStringContainsString('Nationality error:', $exception->getMessage());
            self::assertStringContainsString('CountryOfResidence error:', $exception->getMessage());
            self::assertStringContainsString('Email error:', $exception->getMessage());

            throw $exception;
        }
    }
}
