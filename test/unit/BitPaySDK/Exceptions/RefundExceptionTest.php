<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\RefundException;
use PHPUnit\Framework\TestCase;

class RefundExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(RefundException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-REFUND-GENERIC: An unexpected error occurred while trying to manage the refund-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(161, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new RefundException(
      'My test message',
      161,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new RefundException();
  }
}