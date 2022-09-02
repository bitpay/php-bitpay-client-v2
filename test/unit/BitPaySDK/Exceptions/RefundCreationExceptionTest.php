<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\RefundCreationException;
use PHPUnit\Framework\TestCase;

class RefundCreationExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(RefundCreationException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-REFUND-CREATE: Failed to create refund-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(162, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new RefundCreationException(
      'My test message',
      162,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new RefundCreationException();
  }
}