<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\BitPayException;
use PHPUnit\Framework\TestCase;

class BitPayExceptionTest extends TestCase
{
  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(BitPayException::class, $exception);
  }

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(null, $exception->getApiCode());
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(100, $exception->getCode());
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
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

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new BitPayException();
  }
}