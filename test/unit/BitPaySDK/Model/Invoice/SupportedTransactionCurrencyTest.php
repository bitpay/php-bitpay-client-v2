<?php

namespace BitPaySDK\Test\Model\Invoice;

use BitPaySDK\Model\Invoice\SupportedTransactionCurrency;
use PHPUnit\Framework\TestCase;

class SupportedTransactionCurrencyTest extends TestCase
{
  public function testInstanceOf()
  {
    $supportedTransactionCurrency = $this->createClassObject();
    self::assertInstanceOf(SupportedTransactionCurrency::class, $supportedTransactionCurrency);
  }

  public function testGetEnabled()
  {
    $supportedTransactionCurrency = $this->createClassObject();
    $supportedTransactionCurrency->setEnabled(true);
    self::assertTrue($supportedTransactionCurrency->getEnabled());
  }

  public function testGetReason()
  {
    $expectedReason = "My reason";

    $supportedTransactionCurrency = $this->createClassObject();
    $supportedTransactionCurrency->setReason($expectedReason);
    self::assertEquals($expectedReason, $supportedTransactionCurrency->getReason());
  }

  public function testToArray()
  {
    $supportedTransactionCurrency = $this->createClassObject();
    $this->objectSetters($supportedTransactionCurrency);

    $supportedTransactionCurrencyArray = $supportedTransactionCurrency->toArray();

    self::assertNotNull($supportedTransactionCurrencyArray);
    self::assertIsArray($supportedTransactionCurrencyArray);

    self::assertArrayHasKey('enabled', $supportedTransactionCurrencyArray);
    self::assertArrayHasKey('reason', $supportedTransactionCurrencyArray);

    self::assertEquals(true, $supportedTransactionCurrencyArray['enabled']);
    self::assertEquals("My reason", $supportedTransactionCurrencyArray['reason']);
  }

  public function testToArrayEmptyKey()
  {
    $supportedTransactionCurrency = $this->createClassObject();

    $supportedTransactionCurrencyArray = $supportedTransactionCurrency->toArray();

    self::assertNotNull($supportedTransactionCurrencyArray);
    self::assertIsArray($supportedTransactionCurrencyArray);

    self::assertArrayNotHasKey('enabled', $supportedTransactionCurrencyArray);
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