<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\RefundQueryException;
use PHPUnit\Framework\TestCase;

class RefundQueryExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(RefundQueryException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-REFUND-GET: Failed to retrieve refund-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(163, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new RefundQueryException(
      'My test message',
      163,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new RefundQueryException();
  }
}