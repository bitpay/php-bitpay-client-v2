<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\PayoutRecipientCancellationException;
use PHPUnit\Framework\TestCase;

class PayoutRecipientCancellationExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(PayoutRecipientCancellationException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-PAYOUT-RECIPIENT-CANCEL: Failed to cancel payout recipient-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(194, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new PayoutRecipientCancellationException(
      'My test message',
      194,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new PayoutRecipientCancellationException();
  }
}