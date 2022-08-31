<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\InvoiceCreationException;
use PHPUnit\Framework\TestCase;

class InvoiceCreationExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(InvoiceCreationException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-INVOICE-CREATE: Failed to create invoice-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(102, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new InvoiceCreationException(
      'My test message',
      102,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new InvoiceCreationException();
  }
}