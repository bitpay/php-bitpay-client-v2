<?php
/**
 * Copyright (c) 2019 BitPay
 **/
declare(strict_types=1);

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\PayoutBatchException;
use PHPUnit\Framework\TestCase;

class PayoutBatchExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    self::assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    self::assertInstanceOf(PayoutBatchException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    self::assertEquals(
      'BITPAY-PAYOUT-BATCH-GENERIC: An unexpected error occurred while trying to manage the payout batch-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    self::assertEquals(201, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new PayoutBatchException(
      'My test message',
      201,
      null,
      'CUSTOM-API-CODE'
    );

    self::assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new PayoutBatchException();
  }
}