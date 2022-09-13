<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\RateQueryException;
use PHPUnit\Framework\TestCase;

class RateQueryExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(RateQueryException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-RATES-GET: Failed to retrieve rates-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(142, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new RateQueryException(
      'My test message',
      142,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new RateQueryException();
  }
}