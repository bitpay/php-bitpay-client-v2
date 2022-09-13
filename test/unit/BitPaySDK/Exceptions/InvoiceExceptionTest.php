<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\InvoiceException;
use PHPUnit\Framework\TestCase;

class InvoiceExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(InvoiceException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-INVOICE-GENERIC: An unexpected error occurred while trying to manage the invoice-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(101, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new InvoiceException(
      'My test message',
      101,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new InvoiceException();
  }
}