<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\SubscriptionQueryException;
use PHPUnit\Framework\TestCase;

class SubscriptionQueryExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(SubscriptionQueryException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-SUBSCRIPTION-GET: Failed to retrieve subscription-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(173, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new SubscriptionQueryException(
      'My test message',
      173,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new SubscriptionQueryException();
  }
}