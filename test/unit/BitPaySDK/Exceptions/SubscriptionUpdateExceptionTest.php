<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\SubscriptionUpdateException;
use PHPUnit\Framework\TestCase;

class SubscriptionUpdateExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(SubscriptionUpdateException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-SUBSCRIPTION-UPDATE: Failed to update subscription-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(174, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new SubscriptionUpdateException(
      'My test message',
      174,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new SubscriptionUpdateException();
  }
}