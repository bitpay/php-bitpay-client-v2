<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\RefundCancellationException;
use PHPUnit\Framework\TestCase;

class RefundCancellationExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(RefundCancellationException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-REFUND-CANCEL: Failed to cancel refund object-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(165, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new RefundCancellationException(
      'My test message',
      165,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new RefundCancellationException();
  }
}