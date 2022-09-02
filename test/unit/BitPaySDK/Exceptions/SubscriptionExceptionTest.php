<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\SubscriptionException;
use PHPUnit\Framework\TestCase;

class SubscriptionExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(SubscriptionException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-SUBSCRIPTION-GENERIC: An unexpected error occurred while trying to manage the subscription-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(171, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new SubscriptionException(
      'My test message',
      171,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new SubscriptionException();
  }
}