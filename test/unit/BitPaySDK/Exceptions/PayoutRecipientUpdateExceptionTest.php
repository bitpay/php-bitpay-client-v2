<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\PayoutRecipientUpdateException;
use PHPUnit\Framework\TestCase;

class PayoutRecipientUpdateExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(PayoutRecipientUpdateException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-PAYOUT-RECIPIENT-UPDATE: Failed to update payout recipient-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(195, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new PayoutRecipientUpdateException(
      'My test message',
      195,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new PayoutRecipientUpdateException();
  }
}