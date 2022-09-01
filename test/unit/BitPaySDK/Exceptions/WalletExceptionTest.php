<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\WalletException;
use PHPUnit\Framework\TestCase;

class WalletExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(WalletException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-WALLET-GENERIC: An unexpected error occurred while trying to manage the wallet-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(181, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new WalletException(
      'My test message',
      181,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new WalletException();
  }
}