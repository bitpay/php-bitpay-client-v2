<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\WalletQueryException;
use PHPUnit\Framework\TestCase;

class WalletQueryExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(WalletQueryException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-WALLET-GET: Failed to retrieve supported wallets-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(183, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new WalletQueryException(
      'My test message',
      183,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new WalletQueryException();
  }
}