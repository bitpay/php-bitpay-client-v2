<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\BillUpdateException;
use PHPUnit\Framework\TestCase;

class BillUpdateExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(BillUpdateException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-BILL-UPDATE: Failed to update bill-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(114, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new BillUpdateException(
      'My test message',
      114,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new BillUpdateException();
  }
}