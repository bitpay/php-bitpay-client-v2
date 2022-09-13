<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\BillException;
use PHPUnit\Framework\TestCase;

class BillExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(BillException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-BILL-GENERIC: An unexpected error occurred while trying to manage the bill-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(111, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new BillException(
      'My test message',
      111,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new BillException();
  }
}