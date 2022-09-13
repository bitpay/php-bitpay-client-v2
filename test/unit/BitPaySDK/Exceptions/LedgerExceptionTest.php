<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\LedgerException;
use PHPUnit\Framework\TestCase;

class LedgerExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(LedgerException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-LEDGER-GENERIC: An unexpected error occurred while trying to manage the ledger-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(131, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new LedgerException(
      'My test message',
      131,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new LedgerException();
  }
}