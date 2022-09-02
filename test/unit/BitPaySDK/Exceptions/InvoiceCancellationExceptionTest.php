<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\InvoiceCancellationException;
use PHPUnit\Framework\TestCase;

class InvoiceCancellationExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(InvoiceCancellationException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-INVOICE-CANCEL: Failed to cancel invoice object-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(105, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new InvoiceCancellationException(
      'My test message',
      105,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new InvoiceCancellationException();
  }
}