<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\PayoutCreationException;
use PHPUnit\Framework\TestCase;

class PayoutCreationExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(PayoutCreationException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-PAYOUT-SUBMIT: Failed to create payout-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(122, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new PayoutCreationException(
      'My test message',
      122,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new PayoutCreationException();
  }
}