<?php

namespace BitPaySDK\Test\Exceptions;

use BitPaySDK\Exceptions\RefundNotificationException;
use PHPUnit\Framework\TestCase;

class RefundNotificationExceptionTest extends TestCase
{

  public function testDefaultApiCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals('000000', $exception->getApiCode());
  }

  public function testInstanceOf()
  {
    $exception = $this->createClassObject();
    $this->assertInstanceOf(RefundNotificationException::class, $exception);
  }

  public function testDefaultMessage()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(
      'BITPAY-REFUND-NOTIFICATION: Failed to send refund notification-> ',
      $exception->getMessage()
    );
  }

  public function testDefaultCode()
  {
    $exception = $this->createClassObject();
    
    $this->assertEquals(166, $exception->getCode());
  }

  public function testGetApiCode()
  {
    $exception = new RefundNotificationException(
      'My test message',
      166,
      null,
      'CUSTOM-API-CODE'
    );

    $this->assertEquals('CUSTOM-API-CODE', $exception->getApiCode());
  }

  private function createClassObject()
  {
    return new RefundNotificationException();
  }
}