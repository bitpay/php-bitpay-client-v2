<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\PayoutQueryException;
use PHPUnit\Framework\TestCase;

class PayoutQueryExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(PayoutQueryException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-PAYOUT-BATCH-GET: Failed to retrieve payout batch-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(123, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new PayoutQueryException(
      'My test message',
      123,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new PayoutQueryException();
  }
}