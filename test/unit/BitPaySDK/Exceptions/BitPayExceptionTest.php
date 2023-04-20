<?php
/**
 * Copyright (c) 2019 BitPay
 **/
declare(strict_types=1);

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\BitPayException;
use PHPUnit\Framework\TestCase;

class BitPayExceptionTest extends TestCase
{
  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    self::assertInstanceOf(BitPayException::class, $exception);
  }

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    self::assertEquals(null, $exception->getApiCode());
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    self::assertEquals(100, $exception->getCode());
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    self::assertEquals(
      'BITPAY-GENERIC: Unexpected Bitpay exeption.-> ',
      $exception->getMessage()
    );
  }

  public function testGetApiCode()
  {
    $exception = new BitPayException(
      'My test message',
      100,
      null,
      'CUSTOM-API-CODE'
    );

    self::assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new BitPayException();
  }
}