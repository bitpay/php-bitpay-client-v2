<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\CurrencyException;
use PHPUnit\Framework\TestCase;

class CurrencyExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(CurrencyException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-CURRENCY-GENERIC: An unexpected error occurred while trying to manage the currencies-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(181, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new CurrencyException(
      'My test message',
      181,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new CurrencyException();
  }
}