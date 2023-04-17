<?php

namespace BitPaySDK\Test\Model\Invoice;

use BitPaySDK\Model\Invoice\SupportedTransactionCurrency;
use PHPUnit\Framework\TestCase;

class SupportedTransactionCurrencyTest extends TestCase
{
  public function testInstanceOf()
  {
    $supportedTransactionCurrency = $this->createClassObject();
    $this->assertInstanceOf(SupportedTransactionCurrency::class, $supportedTransactionCurrency);
  }

  public function testGetEnabled()
  {
    $supportedTransactionCurrency = $this->createClassObject();
    $supportedTransactionCurrency->setEnabled(true);
    $this->assertTrue($supportedTransactionCurrency->getEnabled());
  }

  public function testGetReason()
  {
    $expectedReason = "My reason";

    $supportedTransactionCurrency = $this->createClassObject();
    $supportedTransactionCurrency->setReason($expectedReason);
    $this->assertEquals($expectedReason, $supportedTransactionCurrency->getReason());
  }

  public function testToArray()
  {
    $supportedTransactionCurrency = $this->createClassObject();
    $this->objectSetters($supportedTransactionCurrency);

    $supportedTransactionCurrencyArray = $supportedTransactionCurrency->toArray();

    $this->assertNotNull($supportedTransactionCurrencyArray);
    $this->assertIsArray($supportedTransactionCurrencyArray);

    $this->assertArrayHasKey('enabled', $supportedTransactionCurrencyArray);
    $this->assertArrayHasKey('reason', $supportedTransactionCurrencyArray);

    $this->assertEquals(true, $supportedTransactionCurrencyArray['enabled']);
    $this->assertEquals("My reason", $supportedTransactionCurrencyArray['reason']);
  }

  public function testToArrayEmptyKey()
  {
    $supportedTransactionCurrency = $this->createClassObject();

    $supportedTransactionCurrencyArray = $supportedTransactionCurrency->toArray();

    $this->assertNotNull($supportedTransactionCurrencyArray);
    $this->assertIsArray($supportedTransactionCurrencyArray);

    $this->assertArrayNotHasKey('enabled', $supportedTransactionCurrencyArray);
  }

  private function createClassObject(): SupportedTransactionCurrency
  {
    return new SupportedTransactionCurrency();
  }

  private function objectSetters(SupportedTransactionCurrency $supportedTransactionCurrency): void
  {
    $supportedTransactionCurrency->setEnabled(true);
    $supportedTransactionCurrency->setReason("My reason");
  }
}