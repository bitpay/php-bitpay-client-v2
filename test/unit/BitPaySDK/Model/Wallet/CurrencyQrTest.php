<?php

namespace BitPaySDK\Test\Model\Wallet;

use BitPaySDK\Model\Wallet\CurrencyQr;
use PHPUnit\Framework\TestCase;

class CurrencyQrTest extends TestCase
{
  public function testInstanceOf()
  {
    $currencyQr = $this->createClassObject();
    self::assertInstanceOf(CurrencyQr::class, $currencyQr);
  }

  public function testGetType()
  {
    $expectedType = 'BIP21';

    $currencyQr = $this->createClassObject();
    $currencyQr->setType($expectedType);
    self::assertEquals($expectedType, $currencyQr->getType());
  }

  public function testGetCollapsed()
  {
    $currencyQr = $this->createClassObject();
    $currencyQr->setCollapsed(false);
    self::assertFalse($currencyQr->getCollapsed());
  }

  public function testToArray()
  {
    $currencyQr = $this->createClassObject();
    $this->objectSetters($currencyQr);
    $currencyQrArray = $currencyQr->toArray();

    self::assertNotNull($currencyQrArray);
    self::assertIsArray($currencyQrArray);

    self::assertArrayHasKey('type', $currencyQrArray);
    self::assertArrayHasKey('collapsed', $currencyQrArray);

    self::assertEquals('BIP21', $currencyQrArray['type']);
    self::assertEquals(false, $currencyQrArray['collapsed']);
  }

  private function createClassObject(): CurrencyQr
  {
    return new CurrencyQr();
  }

  private function objectSetters(CurrencyQr $currencyQr): void
  {
    $currencyQr->setType('BIP21');
    $currencyQr->setCollapsed(false);
  }
}