<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\SettlementException;
use PHPUnit\Framework\TestCase;

class SettlementExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(SettlementException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-SETTLEMENTS-GENERIC: An unexpected error occurred while trying to manage the settlements-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(151, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new SettlementException(
      'My test message',
      151,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new SettlementException();
  }
}