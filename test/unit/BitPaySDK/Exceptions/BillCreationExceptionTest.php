<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\BillCreationException;
use PHPUnit\Framework\TestCase;

class BillCreationExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(BillCreationException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-BILL-CREATE: Failed to create bill-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(112, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new BillCreationException(
      'My test message',
      112,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new BillCreationException();
  }
}