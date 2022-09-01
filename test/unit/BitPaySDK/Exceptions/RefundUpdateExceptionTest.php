<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\RefundUpdateException;
use PHPUnit\Framework\TestCase;

class RefundUpdateExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(RefundUpdateException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-REFUND-UPDATE: Failed to update refund-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(164, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new RefundUpdateException(
      'My test message',
      164,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new RefundUpdateException();
  }
}