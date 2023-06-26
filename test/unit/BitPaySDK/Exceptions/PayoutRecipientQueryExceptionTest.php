<?php
/**
 * Copyright (c) 2019 BitPay
 **/
declare(strict_types=1);

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\PayoutRecipientQueryException;
use PHPUnit\Framework\TestCase;

class PayoutRecipientQueryExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    self::assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    self::assertInstanceOf(PayoutRecipientQueryException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    self::assertEquals(
      'BITPAY-PAYOUT-RECIPIENT-GET: Failed to retrieve payout recipient-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    self::assertEquals(193, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new PayoutRecipientQueryException(
      'My test message',
      193,
      null,
      'CUSTOM-API-CODE'
    );

    self::assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new PayoutRecipientQueryException();
  }
}