<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\PayoutRecipientCreationException;
use PHPUnit\Framework\TestCase;

class PayoutRecipientCreationExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(PayoutRecipientCreationException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-PAYOUT-RECIPIENT-SUBMIT: Failed to create payout recipient-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(192, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new PayoutRecipientCreationException(
      'My test message',
      192,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new PayoutRecipientCreationException();
  }
}