<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\BillDeliveryException;
use PHPUnit\Framework\TestCase;

class BillDeliveryExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(BillDeliveryException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-BILL-DELIVERY: Failed to deliver bill-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(115, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new BillDeliveryException(
      'My test message',
      115,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new BillDeliveryException();
  }
}