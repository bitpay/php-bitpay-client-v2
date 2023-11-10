<?php
/**
 * Copyright (c) 2019 BitPay
 **/
declare(strict_types=1);

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\BitPayApiException;
use PHPUnit\Framework\TestCase;

class BitPayApiExceptionTest extends TestCase
{
    private const ERROR_MESSAGE = 'someMessage';
    private const BITPAY_CODE = '123';

    public function testInstanceOf(): void
    {
        $exception = $this->createClassObject();
        self::assertInstanceOf(BitPayApiException::class, $exception);
    }

    public function testBitPayCode(): void
    {
        $exception = $this->createClassObject();
        self::assertEquals(self::BITPAY_CODE, $exception->getBitPayCode());
    }

    public function testGetMessage(): void
    {
        $exception = $this->createClassObject();

        self::assertEquals($exception->getMessage(), $exception->getMessage());
    }

    private function createClassObject(): BitPayApiException
    {
        return new BitPayApiException(self::ERROR_MESSAGE, self::BITPAY_CODE);
    }
}