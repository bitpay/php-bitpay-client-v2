<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\InvoiceQueryException;
use PHPUnit\Framework\TestCase;

class InvoiceQueryExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(InvoiceQueryException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-INVOICE-GET: Failed to retrieve invoice-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(103, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new InvoiceQueryException(
      'My test message',
      103,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new InvoiceQueryException();
  }
}