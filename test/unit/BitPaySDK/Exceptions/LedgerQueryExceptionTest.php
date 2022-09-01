<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\LedgerQueryException;
use PHPUnit\Framework\TestCase;

class LedgerQueryExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(LedgerQueryException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-LEDGER-GET: Failed to retrieve ledger-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(132, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new LedgerQueryException(
      'My test message',
      132,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new LedgerQueryException();
  }
}