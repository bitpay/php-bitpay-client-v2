<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\SubscriptionCreationException;
use PHPUnit\Framework\TestCase;

class SubscriptionCreationExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(SubscriptionCreationException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-SUBSCRIPTION-CREATE: Failed to create subscription-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(172, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new SubscriptionCreationException(
      'My test message',
      172,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new SubscriptionCreationException();
  }
}