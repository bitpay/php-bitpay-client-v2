<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\CurrencyQueryException;
use PHPUnit\Framework\TestCase;

class CurrencyQueryExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(CurrencyQueryException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-CURRENCY-GET: Failed to retrieve currencies-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(182, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new CurrencyQueryException(
      'My test message',
      182,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new CurrencyQueryException();
  }
}