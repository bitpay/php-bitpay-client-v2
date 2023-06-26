<?php
/**
 * Copyright (c) 2019 BitPay
 **/
declare(strict_types=1);

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\BillUpdateException;
use PHPUnit\Framework\TestCase;

class BillUpdateExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    self::assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    self::assertInstanceOf(BillUpdateException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    self::assertEquals(
      'BITPAY-BILL-UPDATE: Failed to update bill-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    self::assertEquals(114, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new BillUpdateException(
      'My test message',
      114,
      null,
      'CUSTOM-API-CODE'
    );

    self::assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new BillUpdateException();
  }
}