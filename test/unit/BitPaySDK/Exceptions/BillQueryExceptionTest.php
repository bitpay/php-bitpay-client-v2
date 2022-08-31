<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\BillQueryException;
use PHPUnit\Framework\TestCase;

class BillQueryExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(BillQueryException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-BILL-GET: Failed to retrieve bill-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(113, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new BillQueryException(
      'My test message',
      113,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new BillQueryException();
  }
}