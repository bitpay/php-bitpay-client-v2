<?php
/**
 * Copyright (c) 2019 BitPay
 **/
declare(strict_types=1);

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\PayoutBatchQueryException;
use PHPUnit\Framework\TestCase;

class PayoutBatchQueryExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    self::assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    self::assertInstanceOf(PayoutBatchQueryException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    self::assertEquals(
      'BITPAY-PAYOUT-BATCH-GET: Failed to retrieve payout batch-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    self::assertEquals(203, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new PayoutBatchQueryException(
      'My test message',
      203,
      null,
      'CUSTOM-API-CODE'
    );

    self::assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new PayoutBatchQueryException();
  }
}