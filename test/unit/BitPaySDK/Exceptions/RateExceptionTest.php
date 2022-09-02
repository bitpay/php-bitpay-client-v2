<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\RateException;
use PHPUnit\Framework\TestCase;

class RateExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(RateException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-RATES-GENERIC: An unexpected error occurred while trying to manage the rates-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(141, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new RateException(
      'My test message',
      141,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new RateException();
  }
}