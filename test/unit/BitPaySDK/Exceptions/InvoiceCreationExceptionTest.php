<?php
/**
 * Copyright (c) 2019 BitPay
 **/
declare(strict_types=1);

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\InvoiceCreationException;
use PHPUnit\Framework\TestCase;

class InvoiceCreationExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    self::assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    self::assertInstanceOf(InvoiceCreationException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    self::assertEquals(
      'BITPAY-INVOICE-CREATE: Failed to create invoice-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    self::assertEquals(102, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new InvoiceCreationException(
      'My test message',
      102,
      null,
      'CUSTOM-API-CODE'
    );

    self::assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new InvoiceCreationException();
  }
}