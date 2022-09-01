<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\SettlementQueryException;
use PHPUnit\Framework\TestCase;

class SettlementQueryExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(SettlementQueryException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-SETTLEMENTS-GET: Failed to retrieve settlements-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(152, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new SettlementQueryException(
      'My test message',
      152,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new SettlementQueryException();
  }
}